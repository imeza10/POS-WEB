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
                <?php echo $_GET["cn"]; ?>
            </h1>

                 <?php

                    include '../controller/config/conexion.php';

                    //$empresa = $_POST["empresa_id"];
                    $empresa = "1";

                    if(isset($_GET["c"]))
                    {
                        if($_GET["c"] =="1")
                            $sql = "SELECT * FROM products WHERE empresa_id = '".$empresa."' ";
                        else
                            $sql = "SELECT * FROM products WHERE empresa_id = '".$empresa."' AND category_id = '".$_GET['c']."' ";


                        $resultado = mysqli_query($con, $sql);

                        if ($resultado == false || mysqli_num_rows ( $resultado ) === 0)
                        {
                            echo '
                                <div class="product-container">                    
                                    <div class="item-product-image">
                                        <a href="detalle.php?p=0" target="_self">
                                        <img src="https://www.krupalifashion.com/Skins/site-default-new/images/no_result.png" class="img-fluid w-100 rounded" blank="true">
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
                            while($reg = mysqli_fetch_array($resultado)){
                            $product_id = $reg[0];
                            $product_name = $reg[1];
                            $product_description = $reg[2];
                            $product_price = $reg[3];
                            $product_url = $reg[4];

                            // <a href="detalle.php?p='.$product_name.'" class="category-link" target="_self">
                            echo '
                                <div class="product-container">                    
                                    <div class="item-product-image">
                                        <a href="detalle.php?pn='.$product_name.'&pi='.$product_id.' target="_self">
                                        <img src="'.$product_url.'" class="img-fluid w-100 rounded" blank="true">
                                        </a>
                                    </div> 
                                    <div class="item-product-info">
                                        <h5>'.$product_name.'</h5> 
                                        <p class="item-product-description">'.$product_description.'</p> 
                                        <div class="price-product">
                                            <p class="item-product-price">$&nbsp;'.number_format($product_price).'</p>
                                        </div>
                                    </div>                    
                                </div>';
                            }
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


