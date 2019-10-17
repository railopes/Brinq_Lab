<?php
header("Access-Control-Allow-Origin: *");
function varIsValid($var_){
  $retorno =  (isset($var_) && !empty($var_));
  return $retorno;
}
header('Content-type: application/json');

$_POST = file_get_contents("php://input");
if(varIsValid($_POST)){
  echo json_encode(['nome'=>'raiLopes','data'=>json_decode($_POST)]);

}else{
  echo  json_encode(["Error"=>'body request not send']);
}
http_response_code(200)
?>
