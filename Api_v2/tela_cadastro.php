<?php
header("Access-Control-Allow-Origin: *");
require_once("Crud.class.php");
$CRUD = new Crud();
// $CRUD->cadastrar('Usuario');
// $CRUD->alterar('usuarios');
header("Content-type: application/json");
http_response_code(200);
$items = $CRUD->mostrarLista(['id','nome','email','nivel_acesso','usuario_valido'],'usuarios');
// $items = $CRUD->mostrarLista([],'usuarios');
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

echo json_encode($finalResult);


?>
