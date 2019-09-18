<?php 

	class ExportExcel
	{
		//https://api.whatsapp.com/send?phone=5511967165446
		//https://api.whatsapp.com/send?phone=5511990127713
		function __contruct(){}
		function generateContents($keys,$data/*encoded json*/){

			$headers = $keys;
			$tableData = (array)$data;
			$fileName = md5(rand(0,10000)).".XLS";
			$file = fopen($fileName,"a+");
			
			for($k=0;$k<count($headers);$k++){
				$fString = ($k != count($headers)-1) ? $headers[$k]."\t" : $headers[$k]."\n" ;
				fwrite($file,$fString);
			}
			
			for($x=0;$x<count((array)$data);$x++){
				
				$isAr = (array) $data[$x];
				$strData = '';
				for($c =0;$c<count($headers);$c++) {
					$scapeString = ($c != count($headers)-1)?"\t":"\n";
					
					$strData .= $isAr[$headers[$c]].$scapeString;
				}
				// $strData = $isAr[$headers[0]]."\t".$data[$x]->name."\t".$data[$x]->pass."\n";
				fwrite($file,$strData);
			}
			fclose($file);
			return json_encode([
					"Result"=>(file_exists($fileName) && filesize($fileName) > 0),
					"File"=>$fileName,
					"Linhas"=>count((array)$data),
					"Headers"=>($keys)
				]);

		}
	}	

?>