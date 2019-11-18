<?php  
	header("Content-type: application/json");
	echo $configs =  ( file_get_contents("configureMail.json"));
	/*
	header("Content-type: application/json");
	echo json_encode($configs->body);
	*/
	$conf2 = new stdClass();
	$confs2['nome'] = 'brasil';
	var_dump($conf2);
?>