<?php
require_once("Connection.php");
class Crud
{
  private function insert($table,$columns=array(),$values=array()){
    $myColumns = '('.preg_replace('/(\w+)/','`${1}`',implode(',',$columns)).')';
  	$myValues = '( ';
  	for($i=0;$i<count($values);$i++){
  		$t = ($i !== count($values)-1)?',':'';
  		if(!is_int($values[$i]) && !is_float($text1) ){
  			$myValues .= '\''.$values[$i].'\''.$t;
  		}else{
  			$myValues .= $values[$i].$t;
  		}
  	}
  	$myValues.= ')';
  	$sql = "INSERT INTO `$table` $myColumns VALUES $myValues";
  	return executeDb($sql,true,true);
  }
  private function update($table,$columnAndValue=array(),$field,$prop){
    /*[['campo','valor']['campo','valor']]*/
    $cmpAndvalues = '';
    for($x =0;$x<count($columnAndValue);$x++){
        $text0 = $columnAndValue[$x][0];
        $text1 = $columnAndValue[$x][1];
        $cmpAndvalues .= "`$text0` = ";
        $cmpAndvalues .= (!is_int($text1) && !is_float($text1)) ? "'$text1'":$text1;
        if($x != count($columnAndValue)-1) $cmpAndvalues .= ', ';
    }
    $tProp = (!is_int($text1) && !is_float($text1)) ? "'$prop'" : $prop;
    $sql = "UPDATE `$table` SET $cmpAndvalues WHERE `$field` = $tProp";
    return executeDb($sql,true,false);
  }
  protected function getRequestData(){
    $_POST = @json_decode(file_get_contents("php://input"));
    if(
        isset($_POST) &&
        !empty($_POST) &&
        isset($_POST->body)
      )  { return ($_POST->body); }else{return 0;}
  }
  public function _cadastrar_($tela){
  /*
    switch ($tela) {
      case 'Estoque':
        break;
      case 'Usuario':
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
          break;
      case 'agenda':
      default:

        break;
    }
    */
  }
  public function alterar($tela){
      $_Body = $this->getRequestData();
      if(is_int($_Body)) {
        header("Content-type: application/json");
        http_response_code(400);
        echo json_encode(['Error'=>"Body was not received."]);
        exit();
      }

      header("Content-type: application/json");
      echo json_encode(
        $this->update($_Body->table,$_Body->values,$_Body->field,$_Body->field_value)
      );
  }
  protected function excluir($tela){

  }
  public function mostrarLista_($cmps=array(),$tela){

    if(count($cmps) == 0){
      $cmps = '*';
    }else{
      $cmps = preg_replace('/(\w+)/','`${1}`',implode(',',$cmps));
    }
    $sql = "SELECT $cmps FROM `$tela`";
    // SELECT * FROM usuarios
    return (executeDb($sql,false,false));
  }
}

?>
