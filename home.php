<?php
  session_start();
  $estaLogado = require_once("./class/logged.php");
  if(!$estaLogado){
    // header("Location: /");
    echo "<script>window.location.href='./'</script>";
    exit();
  }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LPP - UMC Universidade</title>
    <link href=".\bootstrap\css\bootstrap.min.css" rel="stylesheet">
    <link href=".\bootstrap\fontawesome\css\font-awesome.css" rel="stylesheet">


    <!-- dattables dependeces -->

    <script src=".\bootstrap\js\jquery-3.4.1.js" charset="utf-8"></script>
    <link rel="stylesheet" href=".\bootstrap\DataTables\DataTables-1.10.20\css\dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href=".\bootstrap\DataTables\datatables.min.css"/>
    <script src=".\bootstrap\DataTables\DataTables-1.10.20\js\jquery.dataTables.min.js" charset="utf-8"></script>
    <script type="text/javascript" src=".\bootstrap\DataTables\datatables.min.js"></script>
    <script src="./bootstrap/js/popper.min.js" charset="utf-8"></script>
    <script src="./bootstrap/js/bootstrap.min.js" charset="utf-8"></script>

  <!-- DEPENDECNIAS DA INTERFACE DE USUARIOS -->
    <script src=".\bootstrap\js\jquery-3.4.1.js" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css"  href="./bootstrap/DataTables/DataTables-1.10.20/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="./bootstrap/DataTables/datatables.min.css"/>
    <link rel="stylesheet" type="text/css"  href="./bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css"  href="./bootstrap\fontawesome\css\font-awesome.min.css">
    <script src="./bootstrap/DataTables/DataTables-1.10.20/js/jquery.dataTables.min.js" charset="utf-8"></script>
    <script type="text/javascript" src="./bootstrap/DataTables/datatables.min.js"></script>
  <!--  -->


</head>

<body>
<div class="page-wrapper  theme chiller-theme toggled ">
  <a id="show-sidebar" class="btn btn-md btn-dark" href="#">
    <i class="fa fa-bars"></i>
  </a>
  <nav id="sidebar" class="sidebar-wrapper">
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
            	<strong> <?php echo $_SESSION['name']; ?></strong>
          	</span>
          <span class="user-role">
            <?php
              switch($_SESSION['profileVersion']){
                case 1:
                  echo "Professor";
                  break;
                case 2:
                  echo "Monitor";
                  break;
                case 3:
                  echo "Coordenador";
                  break;
              }
            ?>
          </span>
        </div>
      </div>
      <div class="sidebar-menu">
        <ul>
          <li class="">
            <a href="/home.php">
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
            <a href="home.php/?t=usuarios">
              <i class="fa fa-users"></i>
              <span>usuarios</span>
            </a>
          </li>
          <li class="sidebar-dropdown">
            <a href="#">
              <i class="fa fa-bar-chart"></i>
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
            <a href="#" id="logout-button">
              <i class=" fa fa-sign-out fa-2x"  aria-hidden="true"></i>
              <span>Sair</span>
            </a>
          </li>
    </div>
  <!-- sidebar-menu  -->
  </nav>
  <main class="page-content h-100 bg-light">
    <div class="container-fluid">
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                ...
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
              </div>
            </div>
          </div>
        </div>

        <!-- ALERTA CONCLUIDO! -->
        <div class="modal fade"  id="alert_finish" role="dialog" aria-hidden="true" style="cursor:pointer" >
          <div class="modal-dialog bg-success borderless" style="cursor:pointer" >
                 <div class="alert alert-success col-12" style="cursor:pointer"  role="alert">
                  usuario cadastrado com sucesso!
                  <button type="button" style="cursor:pointer" class="close" data-dismiss="modal">&times;</button>
                </div>
           </div>
          </div>

        <!-- ADD MODAL -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="_titulo_cad">Novo Usuário</h5>
                <button type="button" class="close" id="form_cad_user_close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body" >
                <form id="form_cad_user" method='post' action='' class="needs-validation" novalidate>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="_name_">nome</label>
                      <input type="text" min=5 class="form-control" id="_name_" placeholder="nome" required>
                      </div>
                      <div class="form-group col-md-6">
                        <label for="_pass_">Senha</label>
                        <input type="password" min=8 max=12 class="form-control" id="_pass_" placeholder="senha" required>
                      </div>
                    </div>
                    <div class="form-row">
                      <div class="form-group col-md-8">
                        <label for="_mail_">Email</label>
                        <input type="email" class="form-control" id="_mail_" placeholder="name@example.com" required>
                        <div class="invalid-feedback">
                          Adicione um email válido.
                        </div>
                      </div>
                      <div class="form-group col-md-4">
                          <label for="_acesso_">Nivel De Acesso</label>
                          <select class="form-control " id="_acesso_" required>
                              <option value="">Selecione</option>
                              <option value="1">Professor</option>
                              <option value="2">Monitor</option>
                              <option value="3">Coordenador</option>
                          </select>
                      </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" style="cursor:pointer" class="btn btn-outline-danger" id="cad_user_cancel_btn" data-dismiss="modal">Cancelar <i class="fa fa-close"></i> </button>
                      <button type="submit" style="cursor:pointer" class="btn btn-success" id="cad_user_btn">Cadastrar <i class="fa fa-send"></i></button>
                    </div>
                </form>
              </div>

            </div>
          </div>
        </div>
        <?php
          if(isset($_GET['t']) && $_GET['t'] == 'usuarios'){
        ?>
        <button type="button" data-toggle="modal" data-target="#addModal" class="btn btn-primary" name="button"><i class="fa fa-user-plus"></i> Cadastrar</button>
        <?php
          require_once("./teste.php");
        }
       ?>
  </main>
  <!-- page-content" -->
</div>
<!-- page-wrapper -->
</body>
<link href="./CSS/home-config.css" rel="stylesheet">
<script src="./JS/dashboard-init.js"></script>

</html>
