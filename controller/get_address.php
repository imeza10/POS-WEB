<?php

    include 'config/conexion.php';

    $session_id = $_POST["session_id"];

    if(isset($session_id))
    {
        $sql = "SELECT * FROM clientes WHERE cl_session_id = '".$session_id."'; ";
        $resultado = mysqli_query($con, $sql);

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Conexión inestable, intenta nuevamente.';
        }
        else{
            $reg = mysqli_fetch_array($resultado);

            $arrayJson['cl_id'] = $reg["cl_id"];
            $arrayJson['cl_name'] = $reg["cl_name"];
            $arrayJson['cl_phone'] = $reg["cl_phone"];
            $arrayJson['cl_address'] = $reg["cl_address"];
            $arrayJson['cl_type_address'] = $reg["cl_type_address"];
            $arrayJson['cl_detail_address'] = $reg["cl_detail_address"];
            $arrayJson['cl_alias_address'] = $reg["cl_alias_address"];
            $arrayJson['cl_instructions_address'] = $reg["cl_instructions_address"];
            $arrayJson['cl_session_id'] = $reg["cl_session_id"];
            $arrayJson['cl_update'] = $reg["cl_update"];

            $arrayJson['success'] = '1';
            $arrayJson['message'] = 'Información encontrada.';  
        }
        

    }else{
        $arrayJson['success'] = '2';
        $arrayJson['message'] = 'Intenta nuevamente, no hay buena conexion.';   
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
