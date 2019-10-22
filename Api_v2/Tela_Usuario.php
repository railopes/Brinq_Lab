<?php
require_once("Crud.class.php");
require_once("../class/Usuarios.class.php");
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");
class Tela_Usuario extends Crud{
  function __construct(){

  }
  public function mostraLista($tela){
    $items = $this->mostrarLista_(['id','nome','email','nivel_acesso','usuario_valido'],'usuarios');
    $validUsers = array_filter($items,
      function($cItem){
        return $cItem[count($cItem)-1] == true;
      }
    );
    $finalResult = array_map(
      function($user){
          return array_slice($user,0,count($user)-1);
      },
      $validUsers
    );
    return $finalResult;
  }

public function cadastrar(){
  $user = new Usuarios();
  $_Body = $this->getRequestData();
  // $data = array();
  $resp = $user->cadastrar($_Body->name,$_Body->pass_,$_Body->mail,$_Body->access);
  echo json_encode($resp);
}
}//FIM DA CLASSE


if(isset($_GET['type'])){
  if($_GET['type'] == 'cad'){
    header("Content-type: application/json");
    $usermanager = new Tela_Usuario();
    $usermanager->cadastrar();
    // exit();
  }
}else{
  // header("Location: /");
  $usermanager = new Tela_Usuario();
  echo json_encode($usermanager->mostraLista('usuarios'));
  exit();
}
?>
