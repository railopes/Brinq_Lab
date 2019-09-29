<?php 
	header("Access-Control-Allow-Origin: *");
	require_once("../class/Export.class.php");
	$_POST = (array)json_decode(file_get_contents("php://input"));
	if(isset($_POST)){
		$ExcelExport = new ExportExcel();
		$tableContentsArray = $ExcelExport->generateContents(array_keys((array)$_POST[0]),$_POST);
		echo ($tableContentsArray);
		function DownloadFile($file) { // $file = include path
			if(file_exists($file)) {
				header('Content-Description: File Transfer');
				header('Content-Type: application/octet-stream');
				header('Content-Disposition: attachment; filename='.basename($file));
				header('Content-Transfer-Encoding: binary');
				header('Expires: 0');
				header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
				header('Pragma: public');
				header('Content-Length: ' . filesize($file));
				ob_clean();
				flush();
				readfile($file);
				exit;
			}
	
		}
		// echo 'http://localhost/'.json_decode($tableContentsArray)->File;
	}

 ?>