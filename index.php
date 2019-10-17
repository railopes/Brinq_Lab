<?php
session_start();
if(isset($_SESSION['name']) && isset($_SESSION['profileVersion'])){
    header("Location: ./res/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
	<title>LPP - UMC Universidade</title>
</head>


<body class='my-bg'>

	<div class="container-fluid">
		<div class="row ">
			<div class="w-100 mt-md-5 mt-5"></div>

			<div class="col-10 offset-1 col-md-4 offset-md-4 text-dark text-center bg-light mt-md-5 mt-5 border rounded-lg my-shadow">

				<h1>LPP</h1>
				<h6>UMC - Universidade</h6>
				<hr>
					<?php
					if(isset($_SESSION['name'])){
						if($_SESSION['name'] == false){
					?>
						<div class="alert alert-danger" role="alert">
						Usuário ou senha inválido
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
						<span aria-hidden="true">&#128473;</span>
						</button>
						</div>
					<?php
						unset($_SESSION['name']);
						}
					}
					?>
					<form method="post" action="./res/login.php" >
						<div class="form-group">
							<label for="input_user">Usuario</label>
							<input type="text" autofocus class="form-control" id="input_user" name='user_name' required placeholder="Usuario">
						</div>
						<div class="form-group">
							<label for="input_pass">Senha</label>
							<input type="password" class="form-control" id="input_pass" name='user_password' required placeholder="Senha">
						</div>
						<button type="submit" class="btn btn-outline-primary px-5">Entrar</button>

					</form>

					<br>
				<div class="w-100"></div>
				<a href="#" class="btn btn-light">Esqueci Minha Senha!</a>
				<div class="w-100"></div>
				<br>
			</div>
		</div>
	</div>
<style>
	.my-shadow{
		box-shadow: 2px 2px 15px black;
	}
	.my-bg{
		background: url('/CSS/img_fundo.jpg') no-repeat center center fixed;
		background-size: cover;
	}
	.my-bg h1, .my-bg h6,.my-bg label{
		user-select: none;
	}
</style>
<script type="text/javascript">

</script>

<script src="/bootstrap/js/jquery-3.3.1.slim.min.js"></script>
<script src="/bootstrap/js/popper.min.js"></script>
<script src="bootstrap/js/bootstrap.min.js" charset="utf-8"></script>
</body>
</html>
