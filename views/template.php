<?php
session_start();

$_SESSION["id_session"] = session_id();
$num_item_carshop = "0";

include 'controller/config/conexion.php';

$session_id = $_SESSION["id_session"];

if(isset($session_id))
{
    $sql = "SELECT COUNT(*) AS num_item_carshop FROM carshop WHERE carshop_session_id = '".$session_id."' AND carshop_item_active = '1'";

    $resultado = mysqli_query($con, $sql);

    if ($resultado == false || mysqli_num_rows ( $resultado ) === 0){
      $num_item_carshop = "0";
    } else{
      $reg = mysqli_fetch_array($resultado);
      $num_item_carshop = $reg[0];
    }
}

?>

<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Meza | POS</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="views/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="views/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="views/dist/css/template.css">



</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
    </ul>

    <ul class="navbar-nav ml-auto">
      <a href="views/carshop.php" class="nav-link">
        <i class="fas fa-shopping-cart"></i>
          <span class="badge badge-danger navbar-badge"><?php echo $num_item_carshop; ?></span>
        </a>
    </ul>
    
  </nav>
  <!-- /.navbar -->

  <section>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index.php" class="brand-link">
        <img src="views/dist/img/MLogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Meza | POS</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="views/dist/img/avatar.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="views/login.php" class="d-block">Usuario invitado</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->

            <li class="nav-item">
              <a href="index.php" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Categorias
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="views/products.php?c=1&cn=Todo" class="nav-link">
                <i class="nav-icon far fa-plus-square"></i>
                <p>
                  Productos
                  <!-- <span class="right badge badge-danger">New</span> -->
                </p>
              </a>
            </li>

          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
  </section>
  <!-- Content Wrapper. Contains page content style ="boder: 5px solid #000" -->
  <div class="content-wrapper">


    <div class="content-header">
      <div class="container-fluid">
        <div id="head-search">
          <div>
            <h2>¿Qué buscas?</h2>
          </div>
          
            <!-- DIV FOR SEARCH-->          
            <div class="container input-group">
              <input class="form-control form-control-navbar" type="search" placeholder="Buscar" aria-label="Buscar">
              <div class="input-group-append">
                <button class="btn btn-navbar navbar-light" type="submit">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>

    <div class="content-body">
      <div class="container">
        <div id="category">

          <div class="row">

          <?php

            include 'controller/config/conexion.php';

            //$empresa = $_POST["empresa_id"];
            $empresa = "1";

            if(!isset($_GET["c"]))
              $sql = "SELECT * FROM category WHERE empresa_id = '".$empresa."'";
            else if($_GET["c"] =="1")
              $sql = "SELECT * FROM productos WHERE empresa_id = '".$empresa."' ";
            else
              $sql = "SELECT * FROM productos WHERE empresa_id = '".$empresa."' AND category_id = '".$_GET['c']."' ";


            $resultado = mysqli_query($con, $sql);

            if ($resultado == false || mysqli_num_rows ( $resultado ) === 0)
            {
              echo '<div class="col-category col-4">
                        <a href="#" class="category-link" target="_self">
                        <img src="http://lorempixel.com/500/500/food" class="img-fluid w-100 rounded" blank="true">
                        <h4  class="title-category">Sin categorias/h4></a>
                    </div>';
            }
            else
            {
                while($reg = mysqli_fetch_array($resultado)){
                  $category_id = $reg[0];
                  $category_name = $reg[1];
                  $category_url = $reg[3];
                  ?>

                  <div class="col-category col-4">
                      <a href="views/products.php?c=<?php echo $category_id; ?>&cn=<?php echo $category_name; ?>" class="category-link" target="_self">
                      <img src="<?php echo $category_url; ?>" class="img-fluid w-100 rounded" blank="true">
                      <h4  class="title-category"><?php echo $category_name; ?></h4></a>
                  </div>
                  
                  <?php
                }
            }
          ?>
            



          </div>

        </div> <!-- /content-body -->
      </div> <!-- /container -->
    </div> <!-- /category -->

    
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
      Todo lo que necesites
    </div>
    <!-- Default to the left -->
    <strong>Meza | POS &copy; 2020 <a href="#">mezaingenieros.com</a>.</strong> Todos los derechos reservados.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="views/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="views/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="views/dist/js/adminlte.min.js"></script>
</body>
</html>
