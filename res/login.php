
<?php
header("Access-Control-Allow-Origin: *");
session_start();
if(!empty($_SESSION) && isset($_SESSION)){
    if($_SESSION['name'] == false){
      echo "<script>window.location.href='../'</script>";
            // header('Location: /');
            exit();
    }
}else{
  require("../Api-BrinqLab/Connection.php");
}
if(isset($_POST) && !empty($_POST)){
    $user = preg_replace('/[^[:alnum:]_\s]/', '',$_POST['user_name']);
    $password = md5($_POST['user_password']);
    $newquery = "SELECT * FROM usuarios WHERE nome = '$user' AND senha ='$password'";
    $resposta =  ["dataTable"=>executeDb($newquery,true,true)];
    // echo "<script>alert('".var_dump($newquery)."')</script>";
    // exit();
    if($resposta['dataTable']['afected_rows'] == 1){
        $_SESSION['name'] = $resposta['dataTable']['row']['nome'];
        $_SESSION['profileVersion']= $resposta['dataTable']['row']['nivel_acesso'];
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
        header("Location: ../home.php");
    }else{
        $_SESSION['name'] = false;
        header("Location: ../");
        exit();
    }
}
unset($_POST);

?>
