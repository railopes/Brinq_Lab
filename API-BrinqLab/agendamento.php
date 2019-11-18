<?php 
header("Access-Control-Allow-Origin: *");
require_once __DIR__."/vendor/autoload.php";
require_once __DIR__."/Connection.php";
use CoffeeCode\Router\Router;

function getCallendarOptions($data){
    // BETWEEN "2016-04-12 00:00:00" AND "2016-04-14 23:59:59" ORDER BY data;
    // /* nomeinst resp data id  n-alunos */
    // $colunas = "a.id_agenda, u.nome,a.nomeInstituicao, a.RG, a.total_alunos, a.data_hora, a.atividade_desc, a.disciplina,a.material_usado" ;
    if(isset($data['id'])){
        $idAgenda = $data['id'];
        $colunas = "a.id_agenda, u.nome,a.nomeInstituicao, a.RG, a.total_alunos, a.data_hora, a.atividade_desc, a.disciplina,a.material_usado,a.confirmado" ;
        $QUERY_ = "SELECT $colunas FROM `agendamento` a join `usuarios` u on a.id_usuario = u.id " ;
        $_query_ = "where a.id_agenda = $idAgenda ";
    }else{
        // $colunas = "a.id_agenda, u.nome,a.nomeInstituicao ,a.RG, a.total_alunos, a.data_hora ";
        $colunas = "a.id_agenda, u.nome,a.nomeInstituicao, a.RG, a.total_alunos, a.data_hora, a.atividade_desc, a.disciplina,a.material_usado,a.confirmado" ;
        $QUERY_ = "SELECT $colunas FROM `agendamento` a join `usuarios` u on a.id_usuario = u.id " ;
        $_query_ = "where data_hora BETWEEN current_date AND DATE_ADD(current_date,INTERVAL 7 DAY) ORDER BY data_hora";
    }
    
    $QUERY = $QUERY_.$_query_;
    $items = database_query($QUERY,false,false);
    $items = array_map(function($currentArray){
        return array_map(function($element){
            if(!is_float($element) && !is_bool($element)){
                return utf8_encode($element);
            }
        },$currentArray);
    },$items);
    foreach($items as $idx => $item){
        $idAgenda = floatval($item[0]);
        $items[$idx][8] = array();
        $sqlmateriais = "SELECT m.descricao FROM materiais m JOIN agendamento_materiais am ON m.idMateriais = am.id_material WHERE am.id_agenda = $idAgenda";
        $allMateriais = database_query($sqlmateriais,false,false);
        
        foreach($allMateriais as $k => $currentMaterial){
            array_push($items[$idx][8],$currentMaterial[0]);
        }
        
    }
    
    header("Content-type: application/json;charset=utf-8");
    echo json_encode(["data"=>$items] );
    if(json_last_error() != JSON_ERROR_NONE ){
        echo json_last_error_msg();
    }
    
//    $optionFinal = ($items);
//    var_dump($optionFinal);
}
function getEscolas($d){
    header("Content-type: application/json;charset=utf-8");
    $escolas = "SELECT distinct `nomeInstituicao` as intituicoes FROM `development_umc`.`agendamento`";
    echo json_encode(["data"=>
        array_map(function($element){
            return array_map(function($subElement){
                return utf8_encode($subElement);
            },$element);
            
        },database_query($escolas,false,false))
    ]);
}

function getDisciplinas($d){
    header("Content-type: application/json;charset=utf-8");
    $escolas = "SELECT distinct `disciplina` as disciplinas FROM `development_umc`.`agendamento`";
    echo json_encode(["data"=>
        array_map(function($element){
            return array_map(function($subElement){
                return utf8_encode($subElement);
            },$element);
            
        },database_query($escolas,false,false))
    ]);
}
set_error_handler( 'error_handler' );
function error_handler( $errno, $errmsg, $filename, $linenum, $vars )
  {
    // error was suppressed with the @-operator
    if ( 0 === error_reporting() )
      return false;

    if ( $errno !== E_ERROR )
      throw new \ErrorException( sprintf('%s: %s', $errno, $errmsg ), 0, $errno, $filename, $linenum );

}

function addAgenda($d){
    //inserir na tabela agendamento_materiais
    header("Content-type: application/json;charset=utf-8");
    $body = getRequestData();
    
    if(is_int($body)) {
        http_response_code(400);
        echo json_encode([
            "Error"=>"o corpo da requisição não foi enviado"
        ]);
        exit;
    }
    try{
        $body->usuario;
        $body->responsavel;
        $body->desc_atividade;
        $body->horario;
        $body->materiais;
        $body->n_alunos;
        $body->instituicao;
        $body->externo;
        $body->instituicao;
    }catch(\Exception $e){
       ## http_response_code(400);
       $message = $e->getMessage();
       $message = explode("::$",$message)[1];
       echo json_encode([
            "Error"=>"Atribudo {$message} não foi encontrado ou definido"
            
        ]);
        exit;
    }
    echo json_encode(["corpo"=>($body)]);

    

}
function autorizeAgenda($data){
    header("Content-type: application/json;charset=utf-8");
    $idAgenda = $data['id'];
    $sqlConsulta = "SELECT * FROM agendamento WHERE id_agenda = $idAgenda";
    $req = database_query($sqlConsulta,false,false);
    if(count($req) !== 1){
        http_response_code(400);
        echo json_encode([
            "Error"=>"Este Agendamento não existe"
        ]);
        exit;
    }
    $sqlConsulta = "UPDATE agendamento SET confirmado = 2 WHERE id_agenda = $idAgenda";
    
    $reqConfirm = database_query($sqlConsulta,true,false);
    if($reqConfirm['afected_rows'] == false){
        http_response_code(301);
        echo json_encode([
            "error"=>"nao foi possivel atualizar o agendamento"
        ]);
        exit;
    }else{ 
        http_response_code(200);
        $oData = date_format(date_create($req[0][5]),"d/m/Y H:i");
        $oEmail = $req[0][11];
        $oNome = $req[0][10];
        $ass = "Agendamento Confirmado!";
        try{
            $body = getRequestData();
            $corpo = $body->mensagem;
        }catch(\Exception $er){
            $corpo ="Olá $oNome, o sua reserva da sala no dia {$oData} foi Confirmado!";
        }
         
        $sentMail = envieEmail($oEmail,$oNome,$corpo,$ass);
        
        if($sentMail){
            echo json_encode([
                "Success"=>"Agendamento confirmado!"
            ]);
        }else{
            echo json_encode([
                "Success"=>"Agendamento confirmado!",
                "mensagem"=>"O Email não pode ser enviado, notifique aos envolvidos!"
            ]);
        }
        // envieEmail($body->mail,$body->usuario,$body->msg);

    }
    
}
function arrayInUTF8(array $items){
    return array_map(function($element){
        return utf8_encode($element);
    },$items);
}
function cancelAgenda($data){
    header("Content-type: application/json;charset=utf-8");
    $idAgenda = $data['id'];
    
    $sqlConsulta = "SELECT * FROM agendamento WHERE id_agenda = $idAgenda";
    
    $req = database_query($sqlConsulta,false,false);
    if(count($req) !== 1){
        http_response_code(400);
        echo json_encode([
            "Error"=>"Este Agendamento não existe"
        ]);
        exit;
    }
    
    
    // echo json_encode(arrayInUTF8($req[0]));
    // exit;
    $sqlConsulta = "UPDATE agendamento SET confirmado = 1 WHERE id_agenda = $idAgenda";
    $reqConfirm = database_query($sqlConsulta,true,false);
    if($reqConfirm['afected_rows'] == false){
        http_response_code(301);
        echo json_encode([
            "error"=>"nao foi possivel cancelar o agendamento"
        ]);
        exit;
    }else{
        $oData = date_format(date_create($req[0][5]),"d/m/Y H:i");
        $ass = "Agendamento Cancelado!";
        $oEmail = $req[0][11];
        $oNome = $req[0][10];
        try{
            $body = getRequestData();
            $corpo = $body->mensagem;
        }catch(\Exception $er){
            $corpo ="Olá $oNome, o sua reserva da sala no dia {$oData} foi Cancelado";
        }
         
        $sentMail = envieEmail($oEmail,$oNome,$corpo,$ass);
        if($sentMail){
            echo json_encode([
                "Success"=>"Agendamento Cancelado!"
            ]);
        }else{
            echo json_encode([
                "Success"=>"Agendamento Cancelado!",
                "mensagem"=>"O Email não pode ser enviado, notifique aos envolvidos!"
            ]);
        }
    }
    
}

function getHorariosIndisponiveis($data){
    header("Content-type: application/json;charset=utf-8");
    $sqlGetHorarios = "SELECT data_hora from agendamento order by data_hora desc";
    $resp = database_query($sqlGetHorarios,false,false);
    $allDate = [];
    foreach ($resp as $i => $_data_) {
        
        array_push($allDate,[
            "start"=> date_format(date_create($_data_[0]),"d/m/Y H:i"),
            "end"=>date_format(date_add(date_create($_data_[0]),new DateInterval("PT50M")),"d/m/Y H:i")
            ]
        );
    }
    // echo json_encode([
    //     "data"=>array_map(function($currentdate){
    //         return date_format(date_create($currentdate),"d/m/Y H:i");
    //     },database_query($sqlGetHorarios,false,false))
    // ]);
    echo json_encode(["data"=>$allDate]);
    exit;
}

function getMateriaisAgendar($d){
    header("Content-type: application/json;charset=utf-8");
    $sqlOsMateriais = "SELECT idMateriais, descricao, qntd_atual FROM materiais";
    $resp = database_query($sqlOsMateriais,false,false);
    echo json_encode($resp);
}
function verificadiavalido($d){
    header("Content-type: application/json;charset=utf-8");
    $meudia = $d['dia'];
    $meudia = explode("_",$meudia);
    $meudia[1] = str_replace("-",":",$meudia[1]);
    $dia = implode(" ",$meudia);
    
    $sqlDiasAgendados = "SELECT data_hora FROM agendamento WHERE data_hora = '$dia'";
    $dbService = database_query($sqlDiasAgendados,false,false);
    if(count($dbService) == 0){
        echo json_encode(["success"=>"o horario esta livre"]);
    }else{
        echo json_encode(['Error'=>'O horario já esta em uso!']);
    }
    
}
$router->group("agenda");
$router->get("/","getCallendarOptions");
$router->get("/item/{id}","getCallendarOptions");
$router->post("/auth/{id}","autorizeAgenda");
$router->post("/cancel/{id}","cancelAgenda");
$router->post("/add","addAgenda");

$router->group("agendamento");
$router->post("/diavalido/{dia}","verificadiavalido");
$router->get("/disciplinas","getDisciplinas");
$router->get("/escolas","getEscolas");
$router->get("/horarios","getHorariosIndisponiveis");
$router->get("/materiais","getMateriaisAgendar");


?>