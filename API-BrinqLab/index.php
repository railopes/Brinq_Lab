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

$router = new Router("http://localhost/API");

$router->group(null);
$router->get("/",function($data){
  
});
/*
* Usuarios -> crud API
*/
$router->group("users");
$router->get("/",function($data){
  header("Content-type: application/json;charset=utf-8");
  // $QUERY = "SELECT `id`,`nome`,`email`,`nivel_acesso`,`usuario_valido` FROM `usuarios`";`u`.`usuario_valido`
  $QUERY = "SELECT  `u`.`id`,`u`.`nome`,`u`.`email`,`p`.`nome` from `usuarios` `u` join `perfis` `p` on `p`.`id` = `u`.`nivel_acesso`";
  $items = database_query($QUERY,false,false);
  $validUsers = array_filter($items,
    function($cItem){
      return $cItem[count($cItem)-1] == true;
    }
  );
  /*
  $finalResult = array_map(
    function($user){
        return array_slice($user,0,count($user)-1);
    },
    $validUsers
  );
  */
  echo json_encode($validUsers);
});

$router->post("/add",function($data){
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
$router->post("/delete/{yourId}",function($data){
  header("Content-type: application/json;charset=utf-8");
  $deleteId = $data['yourId'];
  $deleteQuery = "DELETE FROM `usuarios` WHERE `id` =  $deleteId";
  echo json_encode ( database_query($deleteQuery,true,false) );
});

$router->post("/update/{yourId}",function($data){
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
//End Usuarios



// Materiais --> API

$router->group("materiais");
$router->get("/",function($data){
    header("Content-type: application/json;charset=utf-8"); 
    $thisSql = "SELECT * from `materiais`";
    echo json_encode(
        database_query($thisSql,false,false)
    );
});

$router->post("/delete/{id}",function($data){
    header("Content-type: application/json;charset=utf-8");
    $deleteId = $data['id'];
    $deleteQuery = "DELETE FROM `materiais` WHERE `idMateriais` =  $deleteId";
    echo json_encode ( database_query($deleteQuery,true,false) );
});

$router->post("/add",function($data){
    header("Content-type: application/json;charset=utf-8");
    $data = getRequestData();
    if(!is_int($data)){
      $colunas = array("descricao","qntd_atual","qntd_minima","tipo","ultima_mudanca","data_inclusao");
      $minhaHora = "".date("Y-m-d H:i:s");
      $dados = array(
                $data->descricao,
                $data->qtd_atual,
                $data->qtd_minima,
                $data->material_tipo,
                $minhaHora,
                $minhaHora
            );
      echo json_encode( insert('materiais',$colunas,$dados));
    }else{
      http_response_code(400);
      echo json_encode(['Error'=>"Body was not received."]);
    }
});
$router->post("/update/{id}",function($data){
    header("Content-type: application/json;charset=utf-8");
    $updateId = $data['id'];
    $new_values = getRequestData();
    $sql = "SELECT `descricao`,`disciplinas`,`qntd_atual`,`qntd_minima`,`tipo` FROM `materiais` WHERE `idMateriais` = $updateId ";
    $response = database_query($sql,false,false);
    $conflict = false;
    if(!is_int($new_values) && count($response) == 1){
        $dados = array();
        if(isset($new_values->descricao)){
            if($new_values->descricao != $response[0][0]){
                array_push($dados,["descricao",$new_values->descricao]);
            }else{
                $conflict = true;
            }
        }
        if(isset($new_values->qtd_atual)){
            if((int)$new_values->qtd_atual != (int)$response[0][2]){
                array_push($dados,["qntd_atual",$new_values->qtd_atual]);
            }else{
                $conflict = true;
            }
        }
        if(isset($new_values->qtd_minima)){
            if((int)$new_values->qtd_minima != (int)$response[0][3]){
                array_push($dados,["qntd_minima",$new_values->qtd_minima]);
            }else{
                $conflict = true;
            }
        }
        if(isset($new_values->material_tipo)){
            if($new_values->material_tipo != $response[0][4]){
                array_push($dados,["tipo",$new_values->material_tipo]);
            }else{
                $conflict = true;
            }
        }
        if(count($dados) == 0){
            if($conflict){
                http_response_code(409);
                echo json_encode(['Error'=>"Conflict."]);
                exit;
            }
            http_response_code(400);
            echo json_encode(['Error'=>"Bad Request. Request body was not sended or attributes are invalid."]);
            exit;
        }
        // date_default_timezone_set("America/Sao_Paulo"); //Com Horario de verao
        date_default_timezone_set("Etc/GMT+3"); //Sem horário de verao
        array_push($dados,["ultima_mudanca","".date("Y-m-d H:i:s")]);
        

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
        $myUpdateQuery = "UPDATE `materiais` SET $liquidData WHERE `idMateriais` =  $updateId";
        echo json_encode ( database_query($myUpdateQuery,true,false) );
    }else{
        if(is_int($new_values) && count($response) == 0){
            http_response_code(404);
            echo json_encode(["Error"=>"Body not send and material not exists"]);
            exit;
        }
        if(is_int($new_values)){
            http_response_code(400);
            echo json_encode(['Error'=>"Request body material not found"]);
            exit;
        }
        if(count($response)==0){
            http_response_code(404);
            echo json_encode(['Error'=>"Material not exists."]);
        }
    }
});
//END MATERIAIS
require_once(__DIR__."/agendamento.php");
require_once(__DIR__."/forget.php");
//END OF API
$router->dispatch();

?>
