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
				$strData = $data[$x]->nome."\t".$data[$x]->senha."\t".$data[$x]->id."\n";
				fwrite($file,$strData);
			}
			fclose($file);
			return json_encode([
					"Result"=>true,
					"File"=>$fileName,
					"Linhas"=>count((array)$data),
					"Headers"=>json_encode($keys)
				]);

		}
	}	

?>