<?php

    include 'config/conexion.php';

    $product_id = $_POST["product_id"];
    $session_id = $_POST["session_id"];
    
  
/*
    $product_id = "5";
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

            $sql = "DELETE FROM carshop WHERE carshop_product_id = '".$product_id."' AND carshop_session_id = '".$session_id."'; ";
            $resultado = mysqli_query($con, $sql);  

            if ($resultado == false) {

            $arrayJson["success"] = '0';
            $arrayJson["message"] = 'Conexión inestable, intenta nuevamente.';

            } else {

                $arrayJson['success'] = '1';
                $arrayJson['message'] = 'Eliminado del carrito';            
            }
        }
        

    }else{
        $arrayJson['success'] = '2';
        $arrayJson['message'] = 'Intenta nuevamente, no hay buena conexion.';   
    }

    echo json_encode($arrayJson,JSON_FORCE_OBJECT);
