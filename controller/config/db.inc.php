<?php
	/**
	 * Connector para MySQL con mysqli
	 *	 
	 *
	 */

	class Db
	{
		private $extension;
		private $link;
		private $server;
		private $port;
		private $db;
		private $sql;
		private $user;
		private $password;
		private $connected;

		/**
		 * Constructor de la clase Connector
		 *
		 * @param $server Direcci&oacute;n IP/Nombre del servidor
		 * @param $db Nombre de la base de datos
		 * @param $user Nombre de usuario
		 * @param $password Contraseña para el usaurio
		 * @param $port Puerto del servidor - por defecto es el 3306
		 */

		public function __construct($server, $db, $user, $password, $port = 3306)
		{
			$this->extension = "mysqli";
			$this->server = $server;
			$this->port = ($port != null && $port != "") ? $port : 3306;
			$this->db = $db;
			$this->user = $user;
			$this->password = $password;

			if (!extension_loaded($this->extension))
			{
				die ("<font color='red'><b>ERROR.</b> No est&aacute; cargada la extensi&oacute;n <i>".$this->extension."</i> para PHP ".phpversion()."</font>");
			}
  		}

  		/**
  		 * Configurar y obtener el número del puerto por el que escucha el servidor de datos.
  		 *
  		 * IMPORTANTE.
  		 * Esta configuración aplica unicamente a este controlador, es decir,
  		 * no se altera la configuracion original del motor.
  		 *
  		 * @param $port Puerto por donde escucha el servidor de datos
  		 */

  		public function port($port = null)
		{
			if ($port == null)
			{
				return $this->port;
			}
			else
			{
				$this->port = $port;
			}
		}
		
		/*
		 * Retorna la cadena SQL, empleada para la consulta.
		 * 
		*/
		
		public function sql()
		{
			return $this->sql;
		}

		/**
  		 * Conectar con el servidor de datos
  		 *
  		 * @return true/false Retorna verdadero si se logra establecer conexión, de lo contrario falso
  		 */

		public function connect()
		{
			$this->link = new mysqli($this->server,$this->user,$this->password,$this->db,$this->port);

			if ($this->link->connect_error)
			{
				$this->connected = false;
				return false;
			}
			else
			{
				$this->autocommit(false);
				$this->connected = true;
				return true;
			}
		}
		
		public function isConnected()
		{
			return $this->connected;
		}

		/**
		 * Comenzar a una transacción
		*/

		public function begin()
		{

		}

		/**
		 * Ejecutar una consulta
		 * @param $sql Cadena de texto en lenguaje SQL
		 * @return $result Resultado de la consulta
		*/

		public function query($sql)
		{
			$this->sql = $sql;			
			$result = $this->link->query($this->sql);
			return $result;
		}
		
		/**
		 * Describir simple un tabla
		 *
		 * @param $table Nombre de la tabla
		 * @return $result Campos de la tabla - incluye nombre, tipo de dato, valor por defecto, etc.
		 *
		 */

		public function desc_simple($table)
		{
			$this->sql = "desc ".$table;
			$result = $this->query($this->sql);
			
			return $result;
		}

		/**
		 * Describir un tabla
		 *
		 * @param $table Nombre de la tabla
		 * @return $fields Campos de la tabla - incluye nombre, tipo de dato, valor por defecto, etc.
		 *
		 */

		public function desc($table, $constraint_fields=null)
		{
			$this->sql = "desc ".$table;
			$result = $this->query($this->sql);
			$i = 0;
			while($row = $this->row($result))
			{
				$default = (!empty($row["Default"]) && $row["Default"] != null) ? $row["Default"] : "";

				$name_field = explode("_", $row["Field"]);
				if (count($name_field) > 1)
				{
					if (strtolower($name_field[count($name_field) - 1]) == "id")
					{
						$type = "select";
						$table_constraint = strtolower(substr($row["Field"],0,strpos($row["Field"],"_id")));
						$table_constraint_field = null;
						
						if ($constraint_fields!=null && is_array($constraint_fields))
						{
							foreach($constraint_fields as $i => $data)
							{
								if ($data["table"] == $table_constraint)
								{
									$table_constraint_field = (!empty($data["field"]) && $data["field"] != "") ? $data["field"] : null;
									break;
								}
							}
						}
						
						$result_rows = $this->select($table_constraint, ($table_constraint_field != null) ? "id,".$table_constraint_field : "*");

						if ($this->num_rows($result_rows) > 0)
						{
							$options = 0;
							while($row_ = $this->row($result_rows))
							{
								if ($options == 0 && $row["Null"] == "YES"/* && strtolower(substr($row["Field"],0,strpos($row["Field"],"_id"))) == $table*/)
								{
									$values[] = array("id" => "NULL", "text" => "");
								}
								
								$values[] = array("id" => $row_[0], "text" => urldecode($row_[1]));
								$options++;
							}
						}
						else
						{
							$values[] = array("id" => "NULL", "text" => "");
						}

						$entrar = false;
					}
					else
					{
						$entrar = true;
					}
				}
				else
				{
					$entrar = true;
					$type = $row["Type"];
				}

				if ($entrar)
				{
					$str = explode("(", $row["Type"]);
					switch(strtolower($str[0]))
					{
						case "enum":
						$type  = "select";
						$values_str = str_replace(array("enum","(",")","'"),"",$row["Type"]);
						$values_array = explode(",", $values_str);
						for($i=0; $i < count($values_array); $i++)
						{
							$values[] = array("id" => $values_array[$i], "text" => $values_array[$i]);
						}

						break;

						default:
						$type = $str[0];

						$str = explode(")", $str[1]);
						$max = $str[0];

						$null = $row["Null"];
					}
				}
				
				$fields[] = array("name" => $row["Field"], "type" => $type, "max" => $max, "null" => $null, "values" => $values, "default" => $default);

				$i++;
				$values = null;
			}

			return $fields;
		}

		/**
  		 * Ejecutar una selección de datos
  		 *
  		 * @param $table Tabla en la que desea consultar
  		 * @param $fields Campos que se desea seleccionar - por defecto todos
  		 * @param $where Condicion(es) de la selección
  		 * @param $orderby Criterio de ordenamiento de los registros
  		 * @param $groupby Criterio de agrupación de los registros
  		 * @param $limit Limitar el número de registros en el resultado
  		 * @return $result Resultado de la consulta
  		 */

		public function select($table, $fields = null, $where = null, $orderby = null, $groupby = null, $limit = null, $joins = null)
		{
			$fields = ($fields == null || $fields == "" || $fields == "*") ? "*" : $fields;
			$where = ($where != null || $where != "") ? " where ".$where : "";
			$groupby = ($groupby != null || $groupby != "") ? " group by ".$groupby : "";
			$orderby = ($orderby != null || $orderby != "") ? " order by ".$orderby : "";
			$limit = ($limit != null || $limit != "") ? " limit ".$limit : "";

			$this->sql = "select ".$fields." from ".$table.$joins.$where.$groupby.$orderby.$limit;
			
			$result = $this->query($this->sql);

			return $result;
		}

		/**
  		 * Insertar registros en tablas
  		 *
  		 * @param $table Tabla en la que desea insertar
  		 * @param $array Arreglo de datos a insertar (clave: nombre del campo - valor: dato a insertar)
  		 */

		public function insert($table, $array)
		{
			foreach($array as $field => $value)
			{
				if ($field != "")
				{
					$fields[] = $field;
					$values[] = (/*is_numeric($value) || */strtolower($value) == "null") ? $value : "'".$value."'";
				}
			}

			$this->sql = "insert into ".$table."(".implode(",",$fields).") values (".implode(",",$values).")";
			
			$this->query($this->sql);

			if ($this->affected_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		/**
  		 * Actualizar registros en tablas
  		 *
  		 * @param $table Tabla en la que desea actualizar
  		 * @param $array Arreglo de datos a actualizar (clave: nombre del campo - valor: dato para actualizar)
  		 * @param $id Valor de la Clave primaria/Unica de la tabla
		 * @param $name_field Nombre del campo usado para la actualizacion
  		 */

		public function update($table, $array, $id=-1, $name_field = "id")
		{
			foreach($array as $field => $value)
			{
				if ($field != "")
				{
					//is_numeric($value) || 
					$set[] = $field."=".((strtolower($value) == "null") ? $value : "'".$value."'");
				}
			}

			$this->sql = "update ".$table." set ".implode(", ",$set)." where ".$name_field." = '".$id."'";
			
			$this->query($this->sql);

			if ($this->affected_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		/**
  		 * Eliminar registros de las tablas
  		 *
  		 * @param $table Tabla en la que desea eliminar
  		 * @param $id Valor para comparar con la clave primaria de la tabla
  		 */

		public function delete($table, $id=-1)
		{
			$this->sql = "delete from ".$table." where id = ".$id;

			$this->query($this->sql);

			if ($this->affected_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		/**
  		 * Truncar/Eliminar todos registros de una tabla
  		 *
  		 * @param $table Tabla en la que desea eliminar
  		 * @param $id Valor(es) para comparar con la clave primaria de la tabla separador por guión medio(-)
  		 */

		public function clean($table, $ids = null)
		{
			$this->sql = "delete from ".$table.(($ids != null && $ids != "") ? " where id in (".$ids.")" : "");

			$this->query($this->sql);

			if ($this->affected_rows() > 0)
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		/**
  		 * Confirmar los cambios efectuados en una tabla
  		 */

		public function commit()
		{
			if ($this->link->commit())
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		/**
		 * Deshacer todos los cambios efectuados en las tablas
  		 */

		public function rollback()
		{
			if ($this->link->rollback())
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		/**
  		 * Configurar la auto-confirmación de las sentencia DML
  		 */

		public function autocommit($value)
		{
			if ($this->link->autocommit($value))
			{
				return true;
			}
			else
			{
				return false;
			}
		}

		/**
  		 * Convertir cada registro en matriz
  		 */

		public function row($result)
		{
			return $result->fetch_array();
		}

		/**
  		 * Convertir cada registro en un arreglo(clave: nombre del campo - valor: dato del campo)
  		 */

		public function row_assoc($result)
		{
			return $result->fetch_assoc();
		}

		/**
  		 * Obtener el número registros en un resultado de consulta
  		 */

		public function num_rows($result)
		{
			return $result->num_rows;
		}

		/**
  		 * Obtener el valor del último campo auto-increment, insertado desde esta conexión.
  		 */

		public function last_id($table = null, $field = null)
		{
			return $this->link->insert_id;
		}

		/**
  		 * Obtener la conexión
  		 */

		public function connection()
		{
			return $this->link;
		}

		/**
  		 * Terminar conexión
  		 */

		public function close()
		{
			$this->connected = false;
			$this->link->close();
		}

		/**
  		 * Filas afectadas al ejecutar un sentencia DML
  		 */

		public function affected_rows($result = null)
		{
			return $this->link->affected_rows;
		}

		/**
  		 * Liberar resultado de la memoria
  		 */

		public function free_result($result = null)
		{
			$result->free();
		}

		/**
  		 * Obtener nombre de los campos para el resultado proporcionado
  		 *
  		 * @param $result Resultado para analizar - Para este controlador no es necesario ser explicito
  		 */

		public function fields($result = null)
		{
			while($fieldData = $result->fetch_field())
			{
				$fields[] = $fieldData->name;
			}

			return $fields;
		}
		
		/**
  		 * Obtener # del códifo de error al procesar un sentencia
  		 */

		public function errno($result = null)
		{
			return $this->link->errno;
		}

		/**
  		 * Obtener el mensage de error al procesar un sentencia
  		 */

		public function error($result = null)
		{
			return $this->link->error;
		}

		/**
  		 * Obtener tabla(s) de la base de datos
  		 *
  		 * @param $tables Tablas especificas que se desea analizar, separadas por coma(,) - si no se proporciona este dato, se asumen todas las tables de la base de datos.
  		 */

		public function tables($tables = null)
		{
			$this->sql = "select TABLE_NAME, TABLE_TYPE, TABLE_COMMENT from information_schema.TABLES where TABLE_SCHEMA = '".$this->db."'";

			$aux = split(",",$tables);
			foreach($aux as $data)
			{
				$table = split(":",$data);

				if ($table[0] == "*" || $table[0] == "")
				{
					$all = true;
					$table_permissions["*"] = $table[1]; //Permisos para todas las tablas
					break;
				}
				else
				{
					$all = false;
				}
			}

			if ($tables != null && $tables != "" && !$all)
			{
				$tables = split(",",trim($tables));
				foreach($tables as $table)
				{
					$table_profile = split(":",$table);
					$table_name = $table_profile[0]; //Nombre de la tabla
					$table_permissions[strtolower($table_name)] = $table_profile[1]; //Permisos para la tabla
					$tables_temp[] = "'".$table_name."'";
				}
				$tables = implode(",",$tables_temp);

				$this->sql .= " and TABLE_NAME in (".$tables.")";
			}

			unset($tables);

			$result = $this->query($this->sql);

			while($table = $this->row($result))
			{
				$description= substr($table["TABLE_COMMENT"],0,strrpos($table["TABLE_COMMENT"],"*"));

				$tables[] = array("name" => $table["TABLE_NAME"], "description" => $description, "permissions" => ($all) ? $table_permissions["*"] : $table_permissions[strtolower($table["TABLE_NAME"])], "type" => strtolower($table["TABLE_TYPE"]));
			}

			return $tables;
		}
		
		/* 
		 * Hacer existir variables, tomando como base una consulta SQL/Array
		 * 
		 * $input Consulta SQL o Array
		 * $c_dc Define que se usará para encerrar el valor de las variables, puede se dobe comilla (por defecto) o comilla simple.
		 */
		 
		public function get_variables($input = null, $c_dc = "\"")
		{
			if ($input != null)
			{
				if (is_array($input))
				{
					foreach($input as $key => $value)
					{
						$expresion = "\$".$key."=".$c_dc.$value.$c_dc.";";
						eval($expresion);
					}
				}
				else
				{
					$result = $this->query($input);
					if($this->num_rows($result) > 0)
					{
						while($object = $this->row_assoc($result))
						{
							foreach($object as $key => $value)
							{
								$expresion = "\$".$key."=".$c_dc.$value.$c_dc.";";
								eval($expresion);
							}
						}
					}
				}
			}
		}
		
		/**
		 * Ejecutar funciones
		 */
		
		public function execute_function($name, &$in = null, &$out = null)
		{
			$sql = "select ".$name."(".((is_numeric($in)) ? $in : "'".$in."'").")";
			
			$result = $this->query($sql);
			if ($this->num_rows($result) > 0)
			{
				$row = $this->row($result);
				return $out = $row[0];
			}
			
			return $out;
		}


		/**
  		 * Obtener información del motor de bases de datos - especificamente el nombre y el número de la versión
  		 */

		public function server()
		{
			return "MySQL ".$this->link->server_info;
		}
	}
?>
