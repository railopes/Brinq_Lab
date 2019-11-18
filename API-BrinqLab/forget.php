<?php
    header("Access-Control-Allow-Origin: *");
    require __DIR__."/sendMail/phpmailer/src/SMTP.php";
	require __DIR__."/sendMail/phpmailer/src/OAuth.php";
	require __DIR__."/sendMail/phpmailer/src/POP3.php";
	require __DIR__."/sendMail/phpmailer/src/Exception.php";
	require __DIR__."/sendMail/phpmailer/src/PHPMailer.php";
    require_once __DIR__."/vendor/autoload.php";
    require_once __DIR__."/Connection.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use CoffeeCode\Router\Router;
    function envieEmail($yourmail,$yourname,$msg,$assunto){
        
        $mail = new PHPMailer();
        // $mail->SMTPDebug = 2;//para debugar
        $mail->IsSMTP(); 
        $mail->CharSet = 'UTF-8';			
        $mail->Host = 'tls://smtp.gmail.com:587';
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        
        $mail->SMTPSecure = "tls"; 
        $mail->SMTPAutoTLS = true;
        $mail->Port = 587; 
        $mail->SMTPAuth = true; 
        $mail->Username = "umc.lpp@gmail.com";
        $mail->Password = 'brinquedoteca2019';
        $mail->From = "umc.lpp@gmail.com";
        $mail->FromName = "umc brinquedoteca" ;
        $mail->AddAddress(($yourmail), $yourname); 
        $mail->WordWrap = 50; 
        $mail->IsHTML = true ;
        $mail->Subject = $assunto; 
        $mail->Body = '<br/>' . $msg . '<br/>' ; 
        $mail->AltBody = "$msg" ;
        return $mail->Send();
			
    }

    function userValid(){
        
        $usermail = $_POST['email'];
        $usuarioNome = $_POST['usuario'];
        $usuarioRow = "SELECT * from usuarios WHERE email = '$usermail' AND nome = '$usuarioNome'";
        $resposta = database_query($usuarioRow,false,false);
        if(count($resposta) < 1) { 
            $resposta = ['Error'=>'Usuario não existe!'];
            exit;
        }else{
            
            $alpha = "aAbBcCdDEefFgGhHiIJjKkLlMmNnOoPpQqRrsSTtUuVvwWxXyYZz0123456789=";
            $max = strlen($alpha)-1;
            $encoded = '';
            while(strlen($encoded)<=12){
                $encoded .= $alpha[rand(0,$max)];
            }
            $codigo =$encoded;
            $encoded = md5($encoded);
            $oId = $resposta[0][0];
            
            $atualizar = "UPDATE usuarios SET senha = '$encoded' WHERE id = $oId";
            $db=database_query($atualizar,true,false);
            if($db['afected_rows']){
                http_response_code(200);
                // echo json_encode([
                //     "codigo"=>$codigo,
                //     "senha"=>$encoded,
                //     "id"=>$oId,
                //     "db"=>$db
                // ]);
                //enviarEmail
                $mensagemFinal = "Aqui está sua nova senha: $codigo";
                if(envieEmail($_POST['email'],$_POST['usuario'],$mensagemFinal,"Nova senha umc - lpp")){
                   
                    http_response_code(200);
                    echo json_encode([
                        'Success'=>'sua senha foi alterada com sucesso! Verifique o email'
                    ]);
                }else{
                    http_response_code(400);
                    echo json_encode([
                        "Error"=>'Aconteceu algo Inesperado, solicite uma nova senha!'
                    ]);
                }
            }else{
                http_response_code(400);
                echo json_encode([
                    "Error"=>'Aconteceu algo Inesperado, solicite uma nova senha!'
                ]);
            }

        }
        
        
        

    }

    $router->group('forget');
    // header('content-type: application/json;chraset=utf-8');
    $router->post('/',"userValid");
?>