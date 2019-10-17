<?php session_start(); ?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LPP - UMC Universidade</title>
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/bootstrap/fontawesome/css/font-awesome.css" rel="stylesheet">
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <script src="/bootstrap/js/Jquery-3.4.1.js"></script>



</head>

<body>
<div class="page-wrapper  theme chiller-theme  toggled">
  <a id="show-sidebar" class="btn btn-md btn-dark" href="#">
    <i class="fa fa-bars"></i>
  </a>
  <nav id="sidebar" class="sidebar-wrapper ">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="#">LPP - UMC Universidade</a>
        <div id="close-sidebar">
          <i class="fa fa-times"></i>
        </div>
      </div>
      <div class="sidebar-header">
        <div class="user-info">
        	<i class="fa fa-user fa-4x"></i>
          &ensp;
          	<span class="user-name">
            	<strong> Jhon Smith </strong>
          	</span>
          <span class="user-role">Administrator</span>
        </div>
      </div>
      <div class="sidebar-menu">
        <ul>
          <li class="">
            <a href="#">
              <i class="fa fa-home "></i>
              <span>Home</span>
            </a>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-book"></i>
              <span>Agenda</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Interno</a>
                </li>
                <li>
                  <a href="#">Externo</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="">
            <a href="#">
              <i class="fa fa-users"></i>
              <span>usuarios</span>
            </a>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-print"></i>
              <span>Relatorios</span>
            </a>
            <div class="sidebar-submenu">
              <ul>
                <li>
                  <a href="#">Agendamento</a>
                </li>
                <li>
                  <a href="#">Estoque</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="">
            <a href="#">
              <i class=" fa fa-sign-out fa-2x"  aria-hidden="true"></i>
              <span id="logout-button">Sair</span>
            </a>
          </li>
    </div>
  <!-- sidebar-menu  -->
  </nav>

  <main class="page-content">
    <div class="container-fluid">
      <h6>HELLO_WORLD</h6>
  </main>
  <!-- page-content" -->
</div>
<!-- page-wrapper -->
  <script src="/bootstrap/js/popper.min.js"></script>

</body>
<link href="/CSS/home-config.css" rel="stylesheet">
<script src="/JS/dashboard-init.js">

</script>
</html>
