<?php 
    require_once __DIR__."/vendor/autoload.php";
    require_once __DIR__."/Connection.php";
    header("Content-type: application/json;charset=utf-8");
    
    
    use CoffeeCode\Router\Router;

    function getRequestData(){
      $_POST = @json_decode(file_get_contents("php://input"));
      if(
          isset($_POST) &&
          !empty($_POST) &&
          isset($_POST->body)
        )  { 
            return ($_POST->body); 
        }else{
            return 0;
        }
    }
    $rotas = new Router("http://localhost/API/select_materiais.php");
    $rotas->group(null);
    $rotas->get("/list",function($data){
        $thisSql = "SELECT * from `materiais`";
        echo json_encode(
            database_query($thisSql,false,false)
        );
    });

    $rotas->post("/list",function($data){
        $request = getRequestData();
        
        if(is_nan($request)){
            echo json_encode($request->position);
        }else{
            http_response_code(400);
            echo json_encode(['Error'=>'Corpo não enviado!']);
        }
    });

    $rotas->dispatch();
    


?>