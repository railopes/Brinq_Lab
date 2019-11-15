<?php 
require_once('Connection.php');
class Agenda
{
	private $dataAgendada,$horaAgendada,$professor,$materia,$materialUsado,$atividade,$totalAlunos,$turma,$nomeInst,$RG,$interno;
	
	function __construct($argument)
	{
		
	}
	public static function marcar($data,$hora,$prof,$turma,$atv,$alunosQtd){}
	public static function cancelar($data,$hora,$prof){}
	public static function buscar($data){}
	public static function alterar($data,$hora,$mesmoHorario){}
	public static function verificarDisponibilidade($data,$hora){}
}

?>