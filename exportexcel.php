<?php 
	header("Access-Control-Allow-Origin: *");
	require_once("./class/Export.class.php");
	$_POST = (array)json_decode(file_get_contents("php://input"));
	if(isset($_POST)){
		$ExcelExport = new ExportExcel();
		$tableContentsArray = $ExcelExport->generateContents(array_keys((array)$_POST[0]),$_POST);
		echo ($tableContentsArray);
		// echo 'http://localhost/'.json_decode($tableContentsArray)->File;
	}

 ?>