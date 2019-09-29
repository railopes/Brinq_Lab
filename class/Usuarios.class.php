<?php 

class Usuarios{
	private $nivelDeAcesso,$nome,$login,$eMail,$senha;
	function __construct(){

	}
	public static function cadastrar($nome,$acesso,$login,$email){}
	public static function buscar($tipBusca,$valorBusca){}
	public static function alterar($tipo,$campo,$valor){}
	public static function excluir($login){}
}

 ?>