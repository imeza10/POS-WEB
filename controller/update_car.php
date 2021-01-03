<?php

    include 'config/conexion.php';

    $carshop_product_amount = $_POST["carshop_product_amount"];
    $carshop_instructions = $_POST["carshop_instructions"];
    $carshop_total = $_POST["carshop_total"];
    $product_id = $_POST["product_id"];
    $session_id = $_POST["session_id"];
  
/*
    $product_amount = "3";
    $instructions = "Algo";
    $product_id = "1";  
    $total = "45000";
    $session_id ="4fp2ajq191hk86qmlb320d1cnf";
*/
    if(isset($session_id))
    {
        $sql = "SELECT * FROM carshop WHERE carshop_session_id = '".$session_id."' AND carshop_product_id = '".$product_id."' AND carshop_item_active = '1'; ";
        $resultado = mysqli_query($con, $sql);

        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0) {

            $arrayJson['success'] = '0';
            $arrayJson['message'] = 'El producto no esta en el carrito de compras.'; 
            
        }
        else{ 

            $sql = "UPDATE carshop SET carshop_product_amount = '".$carshop_product_amount."' , carshop_instructions = '".$carshop_instructions."', carshop_total = $carshop_total, carshop_date = (SELECT NOW()) WHERE carshop_product_id = '".$product_id."' AND carshop_session_id = '".$session_id."';";
            $resultado = mysqli_query($con, $sql);  

            if ($resultado == false) {

            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Conexión inestable, intenta nuevamente.';

            } else {

                $arrayJson['success'] = '1';
                $arrayJson['message'] = 'Producto actualizado en el carrito';            
            }
        }
        

    }else{
        $arrayJson['success'] = '2';
        $arrayJson['message'] = 'Intenta nuevamente, no hay buena conexion.';   
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
