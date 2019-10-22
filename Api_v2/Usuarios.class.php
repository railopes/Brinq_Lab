<?php
require 'Connection.php';
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
	function __construct(){

	}
	public  function cadastrar($nome,$senha,$eMail,$perfil){
		$_Body = $this->getRequestData();
		if(!is_int($_Body)){
			$Uname = preg_replace('/[^[:alnum:]_\s]/', '',$_Body->name);
			$colunas = array("nome","senha","perfil","usuario_valido");
			$data = array($Uname,md5($_Body->pass_),$_Body->access,1);
			header("Content-type: application/json");
			echo json_encode( $this->insert('usuarios',$colunas,$data));
		}else{
			header("Content-type: application/json");
			http_response_code(400);
			echo json_encode(['Error'=>"Body was not received."]);
		}
	}
	public static function buscar($tipBusca,$valorBusca){}
	public static function alterar($tipo,$campo,$valor){}
	public static function excluir($login){}
}

 ?>
