<?php
require_once('../Api_v2/Connection.php');
function insertInto($table,$columns=array(),$values=array()){
	$myColumns = '('.preg_replace('/(\w+)/','`${1}`',implode(',',$columns)).')';
	$myValues = '( ';
	for($i=0;$i<count($values);$i++){
		$t = ($i !== count($values)-1)?',':'';
		if(!is_int($values[$i])){
			$myValues .= '\''.$values[$i].'\''.$t;
		}else{
			$myValues .= $values[$i].$t;
		}
	}
	$myValues.= ')';
	$sql = "INSERT INTO `$table` $myColumns VALUES $myValues";
	
	return executeDb($sql,true,true);
}
class Usuarios{
	private $nivelDeAcesso,$nome,$login,$eMail,$senha;

	private function getRequestData(){
		$_POST = @json_decode(file_get_contents("php://input"));
		if(
				isset($_POST) &&
				!empty($_POST) &&
				isset($_POST->body)
			)  { return ($_POST->body); }else{return 0;}
	}

	function __construct(){

	}
	public function cadastrar($nome,$senha,$email,$perfil){
		// $_Body = $this->getRequestData();
		// if(!is_int($_Body)){
			$Uname = preg_replace('/[^[:alnum:]_\s]/', '',$nome);
			/*
			id int primary key auto_increment,
			nome varchar(70) not null,
    	senha varchar(33)not null,
    	email varchar(100) unique not null ,
    	nivel_acesso int,
    	usuario_valido boolean not null,
		*/
			$table = 'usuarios';
			$colunas = array("nome","senha","email","nivel_acesso","usuario_valido");
			// $data = array($Uname,md5($_Body->pass_),$_Body->mail,$_Body->access,1);
			$values = array($Uname,md5($senha),$email,$perfil,true);
			return insertInto($table,$colunas,$values);
			/*
			// header("Content-type: application/json");
			$myColumns = '('.preg_replace('/(\w+)/','`${1}`',implode(',',$colunas)).')';
	  	$myValues = '( ';
	  	for($i=0;$i<count($values);$i++){
	  		$t = ($i !== count($values)-1)?',':'';
	  		if(!is_int($values[$i]) && !is_float($values[$i]) ){
	  			$myValues .= '\''.$values[$i].'\''.$t;
	  		}else{
	  			$myValues .= $values[$i].$t;
	  		}
	  	}
	  	$myValues.= ')';
	  	$sql = "INSERT INTO `$table` $myColumns VALUES $myValues";
	  	return json_encode( executeDb($sql,true,true) );
		}else{
			header("Content-type: application/json");
			http_response_code(400);
			echo json_encode(['Error'=>"Body was not received."]);
		}


			$colunas = array("nome","senha","perfil","usuario_valido");
			$data = array($nome,$senha,$perfil,1);
			return insertInto('usuarios',$colunas,$data);
		*/
	}
	public static function buscar($tipBusca,$valorBusca){}
	public static function alterar($tipo,$campo,$valor){}
	public static function excluir($login){}
}

 ?>
