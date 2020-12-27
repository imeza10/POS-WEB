<?php
  include 'header.php';
?>

    
    <div class="content-wrapper">
        <div class="content-body">
            <div class="container">
            <br>
            <a href="javascript:history.back()" target="_self" class="return">
                <img src="dist/img/back2.png" width="20px" height ="30px">                
            </a>
            <h1>
                <?php echo $_GET["pn"]; ?>
            </h1>

                 <?php

                    include '../controller/config/conexion.php';

                    //$empresa = $_POST["empresa_id"];
                    $empresa = "1";

                    if(isset($_GET["pi"]))
                    {
                        $sql = "SELECT * FROM products WHERE empresa_id = '".$empresa."' AND product_id = '".$_GET["pi"]."' ";
                        $resultado = mysqli_query($con, $sql);

                        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0)
                        {
                            echo ' no data';
                        }
                        else
                        {
                            $reg = mysqli_fetch_array($resultado);
                            $product_id = $reg[0];
                            $product_name = $reg[1];
                            $product_description = $reg[2];
                            $product_price = $reg[3];
                            $product_url = $reg[4];

                            ?>
                            <p id="product_id" style="display:none;"><?php echo $product_id; ?></p>
                            <div class="product-detail">                    
                                <div class="item-product-image-detail">
                                    <img src="<?php echo $product_url ?>" class="img-fluid w-100 rounded" blank="true">
                                </div> 
                                <div class="item-product-info-detail">
                                    <p class="item-product-description-detail"><?php echo $product_description; ?></p> 
                                    
                                </div>
                            </div>
                            
                            <div class="price-product-detail">
                                <p id="price" class="item-product-price-detail">$<?php echo number_format($product_price); ?></p>
                            </div>

                            <div class="instructions">
                                <h3>Detalles</h3> 
                                <textarea id="instructions" placeholder="Deja instrucciones..." wrap="soft" class="form-control" id="__BVID__37" style="resize: none; overflow-y: scroll; height: 86px;"></textarea>
                            </div>

                            <div class="price-product-detail">
                                <p id="total" class="item-product-price-detail">Total: $<?php echo number_format($product_price); ?></p>
                            </div>

                            <div class="add-to-cart">
                                <div id="group-cantidad" role="group" lang="es-ES" tabindex="-1" class="b-form-spinbutton form-control form-control-sm d-inline-flex align-items-stretch">
                                    <button id="btmenos" tabindex="-1" type="button" aria-label="Decrement" aria-keyshortcuts="ArrowDown" class="btn btn-sm border-0 rounded-0 py-0" aria-controls="__BVID__38">
                                        <div>
                                            <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="dash" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-dash b-icon bi"><g transform="translate(8 8) scale(1.25 1.25) translate(-8 -8)">
                                            <path fill-rule="evenodd" d="M3.5 8a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 0 1H4a.5.5 0 0 1-.5-.5z"></path></g></svg>
                                        </div>
                                    </button><!---->
                                    <output id="amount" dir="ltr" role="spinbutton" tabindex="0" aria-live="off" aria-valuemin="1" aria-valuemax="100" aria-valuenow="1" aria-valuetext="1" class="flex-grow-1 align-self-center border-left border-right" id="__BVID__38">
                                        <bdi>1</bdi>
                                    </output>
                                    <button id="btmas" tabindex="-1" type="button" aria-label="Increment" aria-keyshortcuts="ArrowUp" class="btn btn-sm border-0 rounded-0 py-0" aria-controls="__BVID__38">
                                        <div>
                                            <svg viewBox="0 0 16 16" width="1em" height="1em" focusable="false" role="img" aria-label="plus" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi-plus b-icon bi"><g transform="translate(8 8) scale(1.25 1.25) translate(-8 -8)">
                                            <path fill-rule="evenodd" d="M8 3.5a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5H4a.5.5 0 0 1 0-1h3.5V4a.5.5 0 0 1 .5-.5z"></path><path fill-rule="evenodd" d="M7.5 8a.5.5 0 0 1 .5-.5h4a.5.5 0 0 1 0 1H8.5V12a.5.5 0 0 1-1 0V8z"></path></g></svg>
                                        </div>
                                    </button>
                                </div>                                
                            </div>
                            <button id="agregar" type="button" class="btn btn-danger">Agregar al carrito
                            </button>
                    
                    <?php
                        }
                    }
                    else{
                        echo '
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
                    }
                    
                ?>

                  

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


