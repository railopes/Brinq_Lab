<?php
header("Access-Control-Allow-Origin: *");
require __DIR__."/vendor/autoload.php";
require __DIR__."/Connection.php";
use CoffeeCode\Router\Router;

function getRequestData(){
  $_POST = @json_decode(file_get_contents("php://input"));
  if(
      isset($_POST) &&
      !empty($_POST) &&
      isset($_POST->body)
    )  { return ($_POST->body); }else{return 0;}
}

function insert($table,$columns=array(),$values=array()){
  $myColumns = '('.preg_replace('/(\w+)/','`${1}`',implode(',',$columns)).')';
  $myValues = '( ';
  for($i=0;$i<count($values);$i++){
    $t = ($i !== count($values)-1)?',':'';
    if(!is_int($values[$i]) && !is_float($values[$i])){
      $myValues .= '\''.$values[$i].'\''.$t;
    }else{
      $myValues .= $values[$i].$t;
    }
  }
  $myValues.= ')';
  $sql = "INSERT INTO `$table` $myColumns VALUES $myValues";
  return database_query($sql,true,true);
}

$router = new Router("http://umcbrinquedoteca.online/API-BrinqLab");

$router->group(null);
$router->get("/",function($data){
});
/*
* Usuarios -> crud API
*/
$router->get("/users",function($data){
  header("Content-type: application/json;charset=utf-8");
  $QUERY = "SELECT `id`,`nome`,`email`,`nivel_acesso`,`usuario_valido` FROM `usuarios`";
  $items = database_query($QUERY,false,false);
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
});

$router->post("/users/add",function($data){
  header("Content-type: application/json;charset=utf-8");
  $data = getRequestData();
  if(!is_int($data)){
    $colunas = array("nome","senha","email","nivel_acesso","usuario_valido");
    $dados = array($data->name,md5($data->pass),$data->mail,$data->access,true);
    echo json_encode( insert('usuarios',$colunas,$dados));
  }else{
    http_response_code(400);
    echo json_encode(['Error'=>"Body was not received."]);
  }
});

$router->get("/user/{user_id}",function($data){
  header("Content-type: application/json;charset=utf-8");
  $myID = $data['user_id'];
  $sql = "SELECT * FROM `usuarios` WHERE `id` = $myID ";
  echo json_encode(
    database_query($sql,false,false)
  );
});
$router->post("/user/delete/{yourId}",function($data){
  header("Content-type: application/json;charset=utf-8");
  $deleteId = $data['yourId'];
  $deleteQuery = "DELETE FROM `usuarios` WHERE `id` =  $deleteId";
  echo json_encode ( database_query($deleteQuery,true,false) );
});

$router->post("/user/update/{yourId}",function($data){
  header("Content-type: application/json;charset=utf-8");
  $updateId = $data['yourId'];
  $new_values = getRequestData();
  $sql = "SELECT * FROM `usuarios` WHERE `id` = $updateId ";
  $response = database_query($sql,false,false);
  if(!is_int($new_values) && count($response) == 1){
    $dados = array();
    if(isset($new_values->name)){
      array_push($dados,["nome",$new_values->name]);
    }
    if(isset($new_values->pass)){
      array_push($dados,["senha",md5($new_values->pass)]);
    }
    if(isset($new_values->mail)){
      array_push($dados,["email",$new_values->mail]);
    }
    if(isset($new_values->access)){
      array_push($dados,["nivel_acesso",$new_values->access]);
    }
    if(count($dados) == 0){
      http_response_code(400);
      echo json_encode(['Error'=>"Bad Request. Request body was not sended or attributes are invalid."]);
      exit;
    }
    foreach ($dados as $idx => $dadoAtual) {
      $dados[$idx][0] = "`".$dados[$idx][0]."`";
      if(!is_int($dadoAtual[1]) && !is_float($dadoAtual[1])){
        $dados[$idx][1] = " = '".$dadoAtual[1]."'";
      }else{
        $dados[$idx][1] = " = ".$dadoAtual[1];
      }
      $dados[$idx] = implode("",$dados[$idx]);
    }
    $liquidData = implode(",",$dados);
    $deleteQuery = "UPDATE `usuarios` SET $liquidData WHERE `id` =  $updateId";
    echo json_encode ( database_query($deleteQuery,true,false) );
  }else{
    if(is_int($new_values) && count($response) == 0){
      http_response_code(404);
      echo json_encode(["Error"=>"Body not send and user not exists"]);
      exit;
    }
    if(is_int($new_values)){
      http_response_code(400);
      echo json_encode(['Error'=>"Request body does not found"]);
      exit;
    }
    if(count($response)==0){
      http_response_code(404);
      echo json_encode(['Error'=>"User not exists."]);
    }
  }
});
// AGENDAMENTO --> API
/*
$router->group("/agenda");
$router->post("/interno",function($data){
  $data = getRequestData();
});
$router->post("/interno/add",function($data){
  $data = getRequestData();
  if(is_int($data)){
    http_response_code(400);
    echo json_encode(['Error'=>"Bad Request. Request body was not sended or attributes are invalid."]);
    exit;
  }
});
*/

$router->dispatch();
/*
if($router->error()){
  $m = $router->error();
  echo("
  
  <div style='font-family:Arial;width:100%;text-align:center;font-size:40pt;font-weight:bold'>
    <h3>Error:&ensp;<span style='font-size:52pt;color:rgba(210,10,10,.7)'>$m</span></h3>
    <p>Page does not found</p>
    <p style='font-size:20pt;color:rgba(0,0,0,.25)'> This api route are not be defined or not be implemented! </p>
  </div>
  
  ");
  // $router->redirect("/user/$m");
  exit;
  
}
*/

?>
