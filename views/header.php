<?php 
  session_start();
  $num_item_carshop = "0";

  include '../controller/config/conexion.php';

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
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="dist/css/template.css">
  <link href="dist/css/toastr.min.css" rel="stylesheet"/>




</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<p id="session_id" style ="display: none;"><?php echo $_SESSION["id_session"]; ?></p>
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
      <a href="carshop.php" class="nav-link">
        <i class="fas fa-shopping-cart"></i>
          <span style="font-size: .7rem;" id="cantidad_carshop" class="badge badge-danger navbar-badge"><?php echo $num_item_carshop; ?></span>
        </a>
    </ul>
    
  </nav>
  <!-- /.navbar -->

  <section>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-light-primary elevation-4">
      <!-- Brand Logo -->
      <a href="../index.php" class="brand-link">
        <img src="dist/img/MLogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Meza | POS</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
          <div class="image">
            <img src="dist/img/avatar.png" class="img-circle elevation-2" alt="User Image">
          </div>
          <div class="info">
            <a href="#" class="d-block">Usuario invitado</a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
                with font-awesome or any other icon font library -->

            <li class="nav-item">
              <a href="../index.php" class="nav-link">
                <i class="nav-icon fas fa-th"></i>
                <p>
                  Categorias
                </p>
              </a>
            </li>

            <li class="nav-item">
              <a href="products.php?c=1&cn=Todo" class="nav-link">
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