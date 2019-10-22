<?php
require_once('Crud.class.php');
class Tela_Agenda extends Crud{
  function __construct(){
    $this->cadastrar("Agenda");
  }
}
$tl = new Tela_Agenda();

?>
