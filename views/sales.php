<?php
  include 'header.php';
?>


<div class="content-wrapper">
    <div class="content-body">
        <div class="container">
            <br>
            <a style="margin-top: 18px;" href="javascript:history.back()" target="_self" class="return">
                <img src="dist/img/back2.png" width="20px" height="30px">
            </a>
            <h1>
                Confirmar compra
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
                            ?>

            <div class="col-12 table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th style="color: #cd1322;">Cant.</th>
                            <th style="color: #cd1322;">Producto</th>
                            <th style="color: #cd1322;">Precio</th>
                            <th style="color: #cd1322;">Descripción</th>
                            <th style="color: #cd1322;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
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
                        <tr>
                            <td><?php echo $carshop_product_amount; ?></td>
                            <td><?php echo $product_name; ?></td>
                            <td><?php echo number_format($product_price); ?></td>
                            <td><?php echo $product_description; ?></td>
                            <td><?php echo number_format($carshop_total); ?></td>
                        </tr>


                        <?php
                            }
                            ?>



                    </tbody>
                </table>
            </div>

            <div style="display: flex; padding: 20px; text-align: center;" tabindex="-1" role="group"
                class="bv-no-focus-ring">
                <div style="width: 100%;" class="custom-control custom-radio">
                    <input type="radio" name="delivery-type" autocomplete="off" class="custom-control-input"
                        value="domicilio" id="__BVID__18">
                    <label class="custom-control-label" for="__BVID__18">
                        <svg id="Capa_1" enable-background="new 0 0 512 512" height="48" fill="#dc3545"
                            viewBox="0 0 512 512" width="48" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path
                                    d="m166 240c-8.284 0-15 6.716-15 15v182c0 8.284 6.716 15 15 15h180c8.284 0 15-6.716 15-15v-182c0-8.284-6.716-15-15-15zm75 30h30v30h-30zm90 152h-150v-152h30v45c0 8.284 6.716 15 15 15h60c8.284 0 15-6.716 15-15v-45h30z" />
                                <path
                                    d="m504.926 152.265-241-150c-4.852-3.02-11-3.02-15.852 0l-241 150c-4.399 2.738-7.074 7.553-7.074 12.735v70.75c0 5.448 2.954 10.468 7.716 13.113 4.766 2.646 10.586 2.5 15.21-.378l7.074-4.403v252.918c0 8.284 6.716 15 15 15h422c8.284 0 15-6.716 15-15v-252.918l7.074 4.403c4.572 2.846 10.394 3.053 15.21.378 4.762-2.645 7.716-7.665 7.716-13.113v-70.75c0-5.182-2.675-9.997-7.074-12.735zm-52.926 329.735h-392v-256.59l196-121.99 196 121.99zm30-273.254c-22.892-14.248-203.783-126.834-218.074-135.729-2.426-1.51-5.176-2.265-7.926-2.265s-5.5.755-7.926 2.265c-14.314 8.909-195.182 121.481-218.074 135.729v-35.414l226-140.664 226 140.664z" />
                            </g>
                        </svg> Domicilio
                    </label>
                </div>

                <div style="width: 100%;" class="custom-control custom-radio">
                    <input type="radio" name="delivery-type" autocomplete="off" class="custom-control-input"
                        value="tienda" id="__BVID__19">
                    <label class="custom-control-label" for="__BVID__19">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="50" height="50"
                            fill="#dc3545" viewBox="0 0 489.4 489.4" style="enable-background:new 0 0 489.4 489.4;"
                            xml:space="preserve">
                            <g>
                                <g>
                                    <path d="M347.7,263.75h-66.5c-18.2,0-33,14.8-33,33v51c0,18.2,14.8,33,33,33h66.5c18.2,0,33-14.8,33-33v-51
                                                    C380.7,278.55,365.9,263.75,347.7,263.75z M356.7,347.75c0,5-4.1,9-9,9h-66.5c-5,0-9-4.1-9-9v-51c0-5,4.1-9,9-9h66.5
                                                    c5,0,9,4.1,9,9V347.75z" />
                                    <path d="M489.4,171.05c0-2.1-0.5-4.1-1.6-5.9l-72.8-128c-2.1-3.7-6.1-6.1-10.4-6.1H84.7c-4.3,0-8.3,2.3-10.4,6.1l-72.7,128
                                                    c-1,1.8-1.6,3.8-1.6,5.9c0,28.7,17.3,53.3,42,64.2v211.1c0,6.6,5.4,12,12,12h66.3c0.1,0,0.2,0,0.3,0h93c0.1,0,0.2,0,0.3,0h221.4
                                                    c6.6,0,12-5.4,12-12v-209.6c0-0.5,0-0.9-0.1-1.3C472,224.55,489.4,199.85,489.4,171.05z M91.7,55.15h305.9l56.9,100.1H34.9
                                                    L91.7,55.15z M348.3,179.15c-3.8,21.6-22.7,38-45.4,38c-22.7,0-41.6-16.4-45.4-38H348.3z M232,179.15c-3.8,21.6-22.7,38-45.4,38
                                                    s-41.6-16.4-45.5-38H232z M24.8,179.15h90.9c-3.8,21.6-22.8,38-45.5,38C47.5,217.25,28.6,200.75,24.8,179.15z M201.6,434.35h-69
                                                    v-129.5c0-9.4,7.6-17.1,17.1-17.1h34.9c9.4,0,17.1,7.6,17.1,17.1v129.5H201.6z M423.3,434.35H225.6v-129.5
                                                    c0-22.6-18.4-41.1-41.1-41.1h-34.9c-22.6,0-41.1,18.4-41.1,41.1v129.6H66v-193.3c1.4,0.1,2.8,0.1,4.2,0.1
                                                    c24.2,0,45.6-12.3,58.2-31c12.6,18.7,34,31,58.2,31s45.5-12.3,58.2-31c12.6,18.7,34,31,58.1,31c24.2,0,45.5-12.3,58.1-31
                                                    c12.6,18.7,34,31,58.2,31c1.4,0,2.7-0.1,4.1-0.1L423.3,434.35L423.3,434.35z M419.2,217.25c-22.7,0-41.6-16.4-45.4-38h90.9
                                                    C460.8,200.75,441.9,217.25,419.2,217.25z" />
                                </g>
                            </g>
                        </svg> En Sitio
                    </label>
                </div>
            </div>


            <div style="display: none;" class="new-address-form">
                
                <form class="">
                    <div id="input-group-address" role="group" class="form-group"><label
                            id="input-group-address__BV_label_" for="address" class="d-block">Nombre</label>
                        <div class="bv-no-focus-ring"><input id="name" type="text" required="required"
                                class="form-control">

                        </div>
                    </div>

                    <div id="input-group-address" role="group" class="form-group"><label
                            id="input-group-address__BV_label_" for="address" class="d-block">Telefono</label>
                        <div class="bv-no-focus-ring"><input id="phone" type="text" required="required"
                                class="form-control">

                        </div>
                    </div>

                    <div id="input-group-address" role="group" class="form-group"><label
                            id="input-group-address__BV_label_" for="address" class="d-block">Dirección</label>
                        <div class="bv-no-focus-ring"><input id="address" type="text" required="required"
                                class="form-control">

                        </div>
                    </div>

                    <div id="input-group-address" role="group" class="form-group"><label
                            id="input-group-address__BV_label_" for="address" class="d-block">Correo</label>
                        <div class="bv-no-focus-ring"><input id="email" type="text" required="required"
                                class="form-control">

                        </div>
                    </div>

                    <div id="input-group-type" role="group" class="form-group"><label id="input-group-type__BV_label_"
                            for="type" class="d-block">Tipo de domicilio</label>
                        <div class="bv-no-focus-ring"><select id="type" required="required" aria-required="true"
                                class="custom-select">
                                <option value="">Seleccionar</option>
                                <option value="Casa">Casa</option>
                                <option value="Apto">Apartamento</option>
                                <option value="Comercio">Comercio</option>
                            </select>

                        </div>
                    </div>
                    <div id="input-group-address" role="group" class="form-group"><label
                            id="input-group-address__BV_label_" for="complement"
                            class="d-block">Apartamento/Casa</label>
                        <div class="bv-no-focus-ring"><input id="complement" type="text"
                                placeholder="Número, torre, bloque..." class="form-control">

                        </div>
                    </div>
                    <div id="input-group-address" role="group" class="form-group"><label
                            id="input-group-address__BV_label_" for="alias" class="d-block">Alias de la dirección</label>
                        <div class="bv-no-focus-ring"><input id="alias" type="text"
                                placeholder="¿Cómo quieres llamar esta dirección?" required="required"
                                aria-required="true" class="form-control">

                        </div>
                    </div>
                    <div id="input-group-address" role="group" class="form-group"><label
                            id="input-group-address__BV_label_" for="details" class="d-block">Detalles</label>
                        <div class="bv-no-focus-ring"><textarea id="details"
                                placeholder="Agrega instrucciones, barrio, piso, zona..." wrap="soft"
                                class="form-control" style="resize: none; overflow-y: scroll; height: 86px;"></textarea>

                        </div>
                    </div>
                    <div class="button-new-address"><button type="submit" class="btn btn-danger">
                            Guadar Dirección
                        </button></div>
                </form>
            </div>


            <div class="carshop_total">
                <p id="total" class="total_pay">Total: $<?php echo number_format($total); ?></p>
                <div class="pay_carshop">
                    <button id="pagar" onclick="pagar('<?php echo $session_id; ?>')" type="button"
                        class="btn btn-danger">Confirmar compra</button>
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