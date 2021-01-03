<?php

include 'config/conexion.php';

$session_id = $_POST["session_id"];
//$session_id = '4fp2ajq191hk86qmlb320d1cnf';

if(isset($session_id))
{
    $sql = "SELECT * FROM clientes WHERE cl_session_id = '".$session_id."'; ";
    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

        /*
        $arrayJson['success'] = '0';
        $arrayJson['message'] = 'Conexión inestable, intenta nuevamente.';
*/
        $arrayJson[] = array(
            'success' => '0',
            'message' => 'Conexión inestable, intenta nuevamente.'
        );
      
    }
    else{       
        while($reg = mysqli_fetch_array($resultado))

            $arrayJson[] = array(
                'success' => '1',
                'message' => 'Informacion encontrada',
                'cl_id' => $reg['cl_id'],
                'cl_address' => $reg['cl_address'],
                'cl_alias_address' => $reg['cl_alias_address']
            );
        
    }
    

}else{
/*
    $arrayJson['success'] = '2';
    $arrayJson['message'] = 'Intenta nuevamente, no hay buena conexion.';
*/
    
    $arrayJson[] = array(
        'success' => '2',
        'message' => 'Intenta nuevamente, no hay buena conexion.'
    );
    
}

echo json_encode($arrayJson);
//    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
