<?php
session_start();
header("Access-Control-Allow-Origin: *");
$DIR = "./../class";
$estaLogado = require $DIR."/logged.php";
require_once($DIR."/Usuarios.class.php");

try{
  $_POST = @json_decode(file_get_contents("php://input"))->body;
}catch(Exception $e){}

if(!$estaLogado){
  if(isset($_POST)){
    http_response_code(403);
    header('Content-type: application/json');
    echo json_encode(["Error"=>"user can't have permissions"]);
    exit();
  }else{
    header("Location: /");
    exit();
  }
}

header('Content-type: application/json');
if(
    ( isset($_GET['cadTipo']) && !empty($_GET['cadTipo']) ) &&
    ( isset($_POST) && !empty($_POST))
  ){
  switch($_GET['cadTipo']){
    case 1:
      $U = new Usuarios();
      $Uname = preg_replace('/[^[:alnum:]_\s]/', '',$_POST->name);
      echo json_encode( $U::cadastrar($Uname,md5($_POST->pass_),$_POST->access) );
      break;
    case 2:
      break;
    case 3:
      break;
  }
}else{
  http_response_code(400);
  echo json_encode(["Error"=>"Body not sent or 'cadTipo' has not specified."]);

}


?>
