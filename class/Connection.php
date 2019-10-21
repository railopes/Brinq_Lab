<?php
define('HOST','development-umc.mysql.uhserver.com');
define('USER','coordenacao');
define('USER_PASS','Umc@508');
define('MYDB','development_umc');
function executeDb($sql,$typeQuery,$insert){

	$conn = mysqli_connect(HOST,USER,USER_PASS,MYDB);
	if($conn){
		try {
			if(!$insert){
				$result =  mysqli_query($conn,$sql);
			}else{
				$result =  mysqli_query($conn,$sql);
			}
		} catch (Exception $err) {
			return null;
		}
		$sequel = true;
		return ($typeQuery) ?
			Array(
				"afected_rows"=>(!is_bool($result)) ? mysqli_num_rows($result):$result,
				"row"=>(!is_bool($result))?mysqli_fetch_assoc($result):$result,
				"userId"=>(is_bool($result) && $insert) ? mysqli_insert_id($conn): null,
			) :
			mysqli_fetch_all($result,MYSQLI_ASSOC);

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
