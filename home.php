<?php
  session_start();
  $estaLogado = require_once("./class/logged.php");
  if(!$estaLogado){
    // header("Location: /");
    echo "<script>window.location.href='/'</script>";
    exit();
  }
  function getFunctionSys(){
    switch($_SESSION['profileVersion']){
      case 1:
        return "Professor";
        break;
      case 2:
        return "Monitor";
        break;
      case 3:
        return "Coordenador";
        break;
    }
  }
  $functionSys = getFunctionSys();
?>

<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LPP - UMC Universidade</title>
    <link href="/bootstrap\css\bootstrap.css" rel="stylesheet">
    <link href="/bootstrap\fontawesome\css\font-awesome.css" rel="stylesheet">


    <!-- datatables dependeces -->

    <script src="/bootstrap/js/jquery-3.4.1.js" charset="utf-8"></script>
    <link  href="/bootstrap/DataTables/DataTables-1.10.20/css/dataTables.bootstrap.css" rel="stylesheet">
    <link  href="/bootstrap/DataTables/datatables.css" type="text/css" rel="stylesheet"/>
    <script src="/bootstrap/DataTables/DataTables-1.10.20\js\jquery.dataTables.js" charset="utf-8"></script>
    <script src="/bootstrap/DataTables/datatables.js" type="text/javascript" charset="utf-8"></script>
    <script src="/bootstrap/js/popper.min.js" charset="utf-8"></script>
    <script src="/bootstrap/js/bootstrap.js" charset="utf-8"></script>

</head>

<body>
<div class="page-wrapper  theme chiller-theme toggled ">
  <a id="show-sidebar" class="btn btn-md btn-danger sideBar_modification" href="#">
    <i class="fa fa-bars"></i>
  </a>
  <nav id="sidebar" class="sidebar-wrapper">
    <div class="sidebar-content">
      <div class="sidebar-brand">
        <a href="#">LPP - UMC Universidade</a>
        <div id="close-sidebar" class="sideBar_modification">
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
            <?php echo $functionSys; ?>
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
                  <a onclick="gotoagenda()" href="#">Interno</a>
                </li>
                <li>
                  <a href="#">Externo</a>
                </li>
              </ul>
            </div>
          </li>
          <li class="">
            <a onclick="gotoestoque()" href="#">
              <i class="fa fa-cubes"></i>
              <span>Estoque</span>
            </a>
          </li>
          <li class="">
            <a onclick="gotouser()" href="#">
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
                <h5 class="modal-title" id="_titulo_edit">Alterar Usuário</h5>
                <button type="button" class="close" id="form_edit_user_close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>

              <div class="modal-body" >
              <form id="form_edit_user" method='post' action='' class="needs-validation" novalidate>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="edit_name_">nome</label>
                    <input type="text" min=5 class="form-control" id="edit_name_" placeholder="nome" required>
                  </div>
                  <div class="form-group col-md-6">
                    <label for="edit_pass_">Senha</label>
                    <input type="password" min=8 max=12 class="form-control" id="edit_pass_" placeholder="senha" >
                  </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-8">
                    <label for="edit_mail_">Email</label>
                    <input type="email" class="form-control" id="edit_mail_" placeholder="name@example.com" >
                  </div>
                  <div class="form-group col-md-4">
                    <label for="edit_acesso_">Nivel De Acesso</label>
                    <select class="form-control " id="edit_acesso_" >
                      <option value="">Selecione</option>
                      <option value="1">Professor</option>
                      <option value="2">Monitor</option>
                      <option value="3">Coordenador</option>
                    </select>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" style="cursor:pointer" class="btn btn-outline-danger" id="edit_user_cancel_btn" data-dismiss="modal">
                    Cancelar&ensp;
                    <i class="fa fa-close"></i>
                  </button>
                  <button type="submit" style="cursor:pointer" class="btn btn-info" id="edit_user_btn">
                    Salvar&ensp;
                    <i class="fa fa-save"></i>
                  </button>
                </div>
              </form>
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
            if($_SESSION['profileVersion'] != 3){
        ?>
          <h4>Voce não possui acesso a esta pagina!</h4>
          <a href='/' class='btn btn-outline-warning'>
              <i class='fa fa-rotate-left'></i>
              &ensp;clique aqui para retornar&ensp;
          </a>
          <p id='return-timer-usuarios'>Retornando em <span></span> segundos</p>
          <script>
            let timerInput = document.querySelector('#return-timer-usuarios span');
            let x =30;
            function timer(){
              timerInput.innerHTML = x;
              if((x-1)>0){
                setTimeout(function(){timer();},1000);
              }else{
                window.location.href = '/';
              }
              x--;
            }
            timer();
          </script>
          <?php
              unset($_GET['t']);
            }else{
          ?>
        <button type="button" data-toggle="modal" data-target="#addModal" class="btn btn-primary" name="button"><i class="fa fa-user-plus"></i> Cadastrar</button>
        <?php
            require_once(__DIR__."/tela_usuarios.php");
          }
        }
        if(isset($_GET['t']) && $_GET['t'] == 'estoque'){
          include_once(__DIR__."/design_ui/index.html");
        }
        if(isset($_GET['t']) && $_GET['t'] == 'agenda'){
          require_once(__DIR__."/agenda.php");
        }
        ?>
  </main>
  <!-- page-content" -->
</div>
<!-- page-wrapper -->
</body>

<link href="/CSS/home-config.css" rel="stylesheet">
<script src="/JS/dashboard-init.js"></script>

</html>
