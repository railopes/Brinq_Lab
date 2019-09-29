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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Umc - Brinquedoteca</title>
    <link rel="stylesheet" href="CSS/background_login.css">
    <link rel="stylesheet" href="CSS/inicio.css">
    
    <script src="JS/utils.js"></script>
</head>
<body>
    <form action="./res/login.php" method="post" id='form_login'>
        <?php 
            if(isset($_SESSION['name'])){ 
                if($_SESSION['name'] == false){
                    echo "<div id='alert_login'>Usuário ou senha invalido <span id='alert_login_span' onclick='ocult_parent(this)'>&#10006</span></div>";
                    unset($_SESSION['name']);
                }
            }
        ?>
        <div id='Logo' width="200"></div>
        <label for="form_user">Usuario</label>
            <input type="text" name="user_name" id="form_user" required >
        
        <label for="form_pass">Senha</label>
        <input type="password" name="user_password" id="form_pass" required >
        
        <input type="submit" value="Entrar">
        <a href="#">Esqueci Minha Senha!</a>
    </form>
</body>
</html>