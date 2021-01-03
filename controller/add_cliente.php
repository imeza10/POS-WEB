<?php

    include 'config/conexion.php';

    $email = $_POST["email"];
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $type_address = $_POST["type_address"];
    $detail_address = $_POST["detail_address"];
    $alias_address = $_POST["alias_address"];
    $instructions_address = $_POST["instructions_address"];
    $session_id = $_POST["session_id"];
/*
    $email = "algo";
    $name = "algo";
    $phone = "algo";
    $address = "algo";
    $type_address = "algo";
    $detail_address = "algo";
    $alias_address = "algo";
    $instructions_address = "algo";
    $session_id = "algo";
*/

    if(isset($session_id))
    {
        $sql = "INSERT INTO clientes VALUES('0','".$email."','".$name."','".$phone."','".$address."','".$type_address."','".$detail_address."','".$alias_address."','".$instructions_address."','".$session_id."', (SELECT NOW()) )";
        $resultado = mysqli_query($con, $sql);  

        if ($resultado == false) {

        $arrayJson["success"] = '0';
        $arrayJson["message"] = 'Conexión inestable, intenta nuevamente.'.$sql;

        } else {

            $arrayJson['success'] = '1';
            $arrayJson['message'] = 'Dirección agregada con exito.';            
        }        

    }else{
        $arrayJson['success'] = '2';
        $arrayJson['message'] = 'Intenta nuevamente, no hay buena conexion.';   
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
