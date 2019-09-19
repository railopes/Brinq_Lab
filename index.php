<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>UmcBrinquedoteca</title>
    <link rel="stylesheet" href="CSS/inicio.css">
    <script src="utils.js"></script>
</head>
<body>
    <form action="/login.php" method="post" id='form_login'>
        <div id='Logo' width="200"></div>
        <input type="text" name="user_name" id="form_user">
        
        <input type="password" name="user_password" id="form_pass">
        
        <input type="submit" value="Logar-Se">
        <a href="#">Esqueci Minha Senha!</a>
    </form>
<!--     <input type="button" value="SHOW TABELA" id='showmytable'>
    <div id="GV"></div> -->
</body>

<script>
    (function(){
        const FORM_LOGIN = document.querySelector("#form_login");   
            FORM_LOGIN.addEventListener('onsubmit',(ev)=>{
                const form_user = document.querySelector("#form_user");
                const form_pass = document.querySelector("#form_pass");

                if(form_user.value === null || form_user.value === undefined || form_user.value ='' ){
                    // form_user
                }
            });
    })()
    // (function(){
        
    //     document.querySelector('#showmytable').addEventListener('click',(e)=>{
    //         const http ={
    //             url:'./login.php',
    //             method:'GET',
    //             body:null,
    //             loading:function(){
                    
    //             }
    //         }
    //         $ajax.request(http,(response,XHR)=>{
    //             const mydiv = document.querySelector('#GV');
    //             makeGridView(JSON.parse(XHR.res),mydiv)
    //         });
    //     });
    //     //console.clear();
    // })();

    // fetch('login.php').then(function(response) { response.text().then(function(res){console.log(JSON.parse(res))})})
</script>
</html>