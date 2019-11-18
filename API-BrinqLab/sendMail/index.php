<?php 
	require __DIR__."/phpmailer/src/SMTP.php";
	require __DIR__."/phpmailer/src/OAuth.php";
	require __DIR__."/phpmailer/src/POP3.php";
	require __DIR__."/phpmailer/src/Exception.php";

	require __DIR__."/phpmailer/src/PHPMailer.php";

	use PHPMailer\PHPMailer\PHPMailer;
	

	if(isset($_GET['enviar'])){
		if($_GET['enviar'] == 'email'){
			$mensagem = $_GET['msgKey'];
			$mail = new PHPMailer();
			$mail->IsSMTP(); 
			// $mail->SMTPDebug = 2;
			$mail->CharSet = 'UTF-8';
			// $mail->True;
			
			$mail->Host = 'tls://smtp.gmail.com:587';
			$mail->SMTPOptions = array(
			   'ssl' => array(
			     'verify_peer' => false,
			     'verify_peer_name' => false,
			     'allow_self_signed' => true
			    )
			);
			
			$mail->SMTPSecure = "tls"; 
			$mail->SMTPAutoTLS = true;// conexão segura com TLS
			$mail->Port = 587; 
			$mail->SMTPAuth = true; // Caso o servidor SMTP precise de autenticação
			$mail->Username = "umc.lpp@gmail.com"; // SMTP username
			$mail->Password = 'brinquedoteca2019'; // SMTP password
			$mail->From = "umc.lpp@gmail.com"; // From
			$mail->FromName = "umc brinquedoteca" ; // Nome de quem envia o email
			$mail->AddAddress("rai.zeckk@gmail.com", "Rai Lopes"); // Email e nome de quem receberá //Responder
			$mail->WordWrap = 50; // Definir quebra de linha
			$mail->IsHTML = true ; // Enviar como HTML
			$mail->Subject = "Meu mundo minha vida!" ; // Assunto
			$mail->Body = '<br/>' . $mensagem . '<br/>' ; //Corpo da mensagem caso seja HTML
			$mail->AltBody = "$mensagem" ; //PlainText, para caso quem receber o email não aceite o corpo HTML
			
			// print_r($mail);
			
			
			if(!$mail->Send()){ // Envia o email
					// print_r($mail->ErrorInfo);
					echo "Erro no envio da mensagem";
			}else{
				require __DIR__."/mailsend.html";

			}
		}
	}else{
		require __DIR__."/view.html";
	}

?>