<?php 
	class Database
	{
		
		function __construct(){
			
		}

		public function connect($db,$user,$pass,$host){
			return $db.$user.$pass.$host;
		}
	}
?>