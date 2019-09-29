
<?php 
session_start();
if(!empty($_SESSION) && isset($_SESSION)){
    if($_SESSION['name'] == false){
            header('Location: ../index.php');
            exit();        
    }
}
require_once("../class/Connection.php");
if(isset($_POST) && !empty($_POST)){
    $user = preg_replace('/[^[:alnum:]_\s]/', '',$_POST['user_name']);
    $password = md5($_POST['user_password']);
    $newquery = "SELECT * FROM usuarios WHERE nome = '$user' AND senha ='$password'";
    // header("Content-type: Application/JSON");
    $resposta =  ["dataTable"=>executeDb($newquery,true,4)];
    if($resposta['dataTable']['afected_rows'] == 1){
        $_SESSION['name'] = $resposta['dataTable']['row']['nome'];
        $_SESSION['profileVersion']= $resposta['dataTable']['row']['perfil'];
    }else{
        $bult =true;
    }

}
if(!isset($bult)&& !empty($bult)){
    if(!$bult){
        echo json_encode($resposta);
    }
    
    
}else{
    if(isset($_SESSION) && !empty($_SESSION)){
        echo "<br/><a href='./logout.php'>Desloga-se</a>"; 
    }else{
        $_SESSION['name'] = false;
        header("Location: ../index.php");
        exit();
    }
}
unset($_POST);

?>