<?php
  include 'header.php';
?>

    
    <div class="content-wrapper">
        <div class="content-body">
            <div class="container">
            <br>
            <a style="margin-top: 18px;" href="javascript:history.back()" target="_self" class="return">
                <img src="dist/img/back2.png" width="20px" height ="30px">                
            </a>
            <h1>
                Carrito de compras
            </h1>

                 <?php

                    include '../controller/config/conexion.php';

                    //$empresa = $_POST["empresa_id"];
                    $empresa = "1";
                    $session_id = $_SESSION["id_session"];

                    if(isset($session_id))
                    {
                        $sql = "SELECT * FROM products p INNER JOIN carshop c ON p.product_id= c.carshop_product_id WHERE carshop_session_id = '".$session_id."' AND carshop_item_active = '1'";

                        $resultado = mysqli_query($con, $sql);

                        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0)
                        {
                            echo '
                                <div class="product-container">                    
                                    <div class="item-product-image">
                                        <a href="detalle.php?p=0" target="_self">
                                        <img src="https://shop.centauro.es/_ui/responsive/common/images/empty_cart.png" class="img-fluid w-100 rounded" blank="true">
                                        </a>
                                    </div> 
                                    <div class="item-product-info">
                                        <h5>No hay productos aqui</h5> 
                                        <p class="item-product-description"></p> 
                                        <div class="price-product">
                                            <p class="item-product-price">$&nbsp;0.0</p>
                                        </div>
                                    </div>                    
                                </div>';
                        }
                        else
                        {
                            $total = 0;
                            while($reg = mysqli_fetch_array($resultado)){
                            $product_id = $reg[0];
                            $product_name = $reg[1];
                            $product_description = $reg[2];
                            $product_price = $reg[3];
                            $product_url = $reg[4];
                            $carshop_instructions = $reg[9];
                            $carshop_product_amount = $reg[10];
                            $carshop_total = $reg[11];
                            $total += $carshop_total;
                            ?>
                            <!-- <a href="detalle.php?p='.$product_name.'" class="category-link" target="_self"> -->
                            
                                <div id= "product-<?php echo $product_id; ?>" class="product-container">                    
                                    <div class="item-product-image">
                                        <a href="detalle.php?pn=<?php echo $product_name ?>&pi=<?php echo $product_id ?> target=_self">
                                        <img src="<?php echo $product_url; ?>" class="img-fluid w-100 rounded" blank="true">
                                        </a>
                                    </div> 
                                    <div class="item-product-info">
                                        <h5 id="product_name"><?php echo $product_name; ?></h5> 
                                        <p class="item-product-description"><?php echo $product_description; ?></p>
                                        <textarea id="instructions-<?php echo $product_id; ?>" class="item-product-description"><?php echo $carshop_instructions; ?></textarea> 
                                        <div class="price-product">
                                            <p id="price-<?php echo $product_id; ?>" class="item-product-price"><?php echo "$&nbsp;".number_format($product_price); ?></p>
                                        </div>
                                    </div>
                                    <div class="item-product-amount">
                                        <div class="price-product-detail">
                                            <p id="subtotal-<?php echo $product_id; ?>" class="item-product-price-detail">Subtotal $<?php echo number_format($carshop_total); ?></p>
                                        </div>

                                        <div class="add-to-cart">
                                            <div id="group-cantidad" role="group" lang="es-ES" tabindex="-1" class="b-form-spinbutton form-control form-control-sm d-inline-flex align-items-stretch">
                                                <button id="btmenos-<?php echo $product_id; ?>" onclick="btmenos('btmenos-<?php echo $product_id; ?>','<?php echo $product_id; ?>', '<?php echo $session_id; ?>')" tabindex="-1" type="button" aria-label="Decrement" aria-keyshortcuts="ArrowDown" class="btn btn-sm border-0 rounded-0 py-0" aria-controls="__BVID__38">
                                                    <div>
                                                        <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="dash" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-dash b-icon bi"><g transform="translate(8 8) scale(1.25 1.25) translate(-8 -8)">
                                                        <path fill-rule="evenodd" d="M3.5 8a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.5-.5z"></path></g></svg>
                                                    </div>
                                                </button><!---->
                                                <output id="amount-<?php echo $product_id; ?>" dir="ltr" role="spinbutton" tabindex="0" aria-live="off" aria-valuemin="1" aria-valuemax="100" aria-valuenow="1" aria-valuetext="1" class="flex-grow-1 align-self-center border-left border-right" id="__BVID__38">
                                                    <bdi><?php echo $carshop_product_amount; ?></bdi>
                                                </output>
                                                <button id="btmas-<?php echo $product_id; ?>" onclick="btmas('btmas-<?php echo $product_id; ?>', '<?php echo $product_id; ?>', '<?php echo $session_id; ?>')" tabindex="-1" type="button" aria-label="Increment" aria-keyshortcuts="ArrowUp" class="btn btn-sm border-0 rounded-0 py-0" aria-controls="__BVID__38">
                                                    <div >
                                                        <svg  viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="plus" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-plus b-icon bi"><g transform="translate(8 8) scale(1.25 1.25) translate(-8 -8)">
                                                        <path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"></path><path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"></path></g></svg>
                                                    </div>
                                                </button>
                                            </div>                             
                                        </div>  
                                    </div>                                      
                                    <div  id="carshop_delete" onclick="bteliminar('<?php echo $product_id; ?>', '<?php echo $session_id; ?>')">
                                        <a href="#"><img class="del_car" id="del_car" src="dist/img/del-red.png" alt="Eliminar del carrito de compras"></a>
                                    </div> 
                                </div>

                            <?php
                            }
                            ?>
                            
                            
                            <div class="carshop_total">
                                <p id="total" class="total_pay">Total: $<?php echo number_format($total); ?></p>
                                <div class="pay_carshop">
                                    <a href="../index.php"><button  id="seguir_comprando" type="button" class="btn">Seguir comprando</button></a>
                                    <a href="sales.php"><button id="pagar" type="button" class="btn btn-danger">Ir a Pagar</button></a>
                                </div>
                                
                            </div>
                            <?php
                        }
                    }
                    else{
                        ?>
                            <div class="product-container">                    
                                <div class="item-product-image">
                                    <img src="http://lorempixel.com/166/166/food" class="img-fluid w-100 rounded" blank="true">
                                </div> 
                                <div class="item-product-info">
                                    <h5>No hay productos aqui</h5> 
                                    <p class="item-product-description"></p> 
                                    <div class="price-product">
                                        <p class="item-product-price">$&nbsp;0.0</p>
                                    </div>
                                </div>                    
                            </div>';
                            <?php
                    }
                    
                ?>
                <!--
                    <div class="product-container">                    
                        <div class="item-product-image">
                            <img src="http://lorempixel.com/166/166/food" class="img-fluid w-100 rounded" blank="true">
                        </div> 
                        <div class="item-product-info">
                            <h5>Lomo Bistec</h5> 
                            <p class="item-product-description">Lomo Bistec, Carne de res bañada en salsa criolla, huevo frito con papa en casco y arroz</p> 
                            <div class="price-product">
                                <p class="item-product-price">$&nbsp;33.900</p>
                            </div>
                        </div>                    
                    </div>
                -->    
                


            </div><!-- /containery -->
        </div> <!-- /content-body -->    
    </div><!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->



<?php 
    include 'footer.php';
?>
