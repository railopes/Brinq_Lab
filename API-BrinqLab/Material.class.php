<?php
namespace Tela;
try{
    @require_once __DIR__."/Connection.php";
}catch(Exception $e){}

class Material{
    
    function __construct(){
        echo json_encode(["Mensage"=>"Execute your query here"]);
    }
    public function cadMaterial($dados){
	echo json_encode(["message"=>"user_cadastrado_com_sucesso"]);
    }
    public function listaMaterial(){

    }
    public function editaMaterial($editId,$novosDados){

    }
    public function removeMaterial($materialId){

    }
}
