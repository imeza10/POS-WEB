<?php

    include 'config/conexion.php';

    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $type_address = $_POST["type_address"];
    $detail_address = $_POST["detail_address"];
    $alias_address = $_POST["alias_address"];
    $instructions_address = $_POST["instructions_address"];
    $session_id = $_POST["session_id"];


    if(isset($session_id))
    {
        $sql = "SELECT * FROM carshop WHERE carshop_session_id = '".$session_id."' AND carshop_product_id = '".$product_id."' AND carshop_item_active = '1'; ";
        $resultado = mysqli_query($con, $sql);

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $sql = "INSERT INTO carshop VALUES('0','".$product_id."','".$instructions."','".$product_amount."','".$total."', (SELECT NOW()),'1','".$session_id."' )";
            $resultado = mysqli_query($con, $sql);  

            if ($resultado == false) {

            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Conexión inestable, intenta nuevamente.'.$sql;

            } else {

                $arrayJson['success'] = '1';
                $arrayJson['message'] = 'Agregado al carrito';            
            }
        }
        else{
            $arrayJson['success'] = '3';
            $arrayJson['message'] = 'Ya agregó el producto al carrito de compras.';  
        }
        

    }else{
        $arrayJson['success'] = '2';
        $arrayJson['message'] = 'Intenta nuevamente, no hay buena conexion.';   
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
