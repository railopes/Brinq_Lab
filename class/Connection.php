<?php 
define('HOST','development-umc.mysql.uhserver.com');
define('USER','coordenacao');
define('USER_PASS','Umc@508');
define('MYDB','development_umc');
function executeDb($sql,$typeQuery,$mode = 5,$values = Array()){
	// echo HOST."<br/>".USER."<br/>".USER_PASS."<br/>".MYDB."<br/>";
	$conn = mysqli_connect(HOST,USER,USER_PASS,MYDB);
	if($conn){
		try {
			switch($mode){
				case 1:/* select*/
				$result =  mysqli_query($conn,$sql );
				
					break;
				case 2:/* insert*/
					break;
				case 3:/*update*/
					break;
				case 4:/* logic delete {update}*/
					$sequel = false;
					break;
				default:
					$sequel = true;
					break;

			}
			$result =  mysqli_query($conn,$sql );
		} catch (Exception $err) {
			return null;
		}
		
		// echo $result;
		return ($typeQuery) ? Array("afected_rows"=>(!is_bool($result))?mysqli_num_rows($result):$result,"Query"=>$sequel,"row"=>mysqli_fetch_assoc($result)) : mysqli_fetch_all($result,MYSQLI_ASSOC) ;
	}else{
		die;
		if (mysqli_connect_errno()) {
			printf("Connect failed: %s\n", mysqli_connect_error());
			exit();
		}
	}
	mysqli_close($conn);
}

?>