
<?php 
session_start();
if(!empty($_SESSION) && isset($_SESSION)){
    if(isset($_POST)){
        if($_SESSION['name'] === $_POST['user_name']){
            header('Location: index.php');
            exit();        
        }
    }
}
require_once("class/Connection.php");
if(isset($_POST)){
    $user = preg_replace('/[^[:alnum:]_\s]/', '',$_POST['user_name']);
    $password = md5($_POST['user_password']);
    $newquery = "SELECT * FROM usuarios WHERE name = '$user' AND pass ='$password'";
    header("Content-type: Application/JSON");
    $resposta =  ["dataTable"=>executeDb($newquery,true,4)];
    if($resposta['dataTable']['afected_rows'] == 1){
        $_SESSION['name'] = $resposta['dataTable']['row']['name'];
        $_SESSION['profileVersion']= $resposta['dataTable']['row']['user_profile'];
    }else{
        $bult =true;
    }
}
if(!isset($bult)){
    echo json_encode($resposta);
}else{
    /*
    session_unset();
    session_destroy();
    */
    echo json_encode(["dataTable"=>[
        "verification"=>(isset($_SESSION) && !empty($_SESSION)),
        "SessionLogged"=>(isset($_SESSION['name'])),
        "sessionname"=>(isset($_SESSION['name']))?$_SESSION['name']:false
        ]]);
}






?>