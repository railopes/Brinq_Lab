<?php 

session_start(); 
// setcookie(session_name(),session_id(),time()+$lifetime);
if(!isset($_SESSION['name']) && !isset($_SESSION['profileVersion'])){
	header("Location: ./index.php");
	exit();
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta charset="UTF-8">
	<title>Painel - LPP</title>
	<!-- <link rel="stylesheet" href="./CSS/global.css"> -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>

<div class="container">
	<div class="row">
		<div class="col">Column</div>
		<div class="col">Column</div>
		

	</div>
	<div class="row">
		<div class="col">Column</div>
		<div class="col">Column</div>
		<div class="col">Column</div>
	</div>
	
</div>
</body>

</html>