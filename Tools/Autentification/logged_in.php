<?php 
class logged_in{

	private $db;
	private $db_user;
			
			function __construct(){
				
			include("db_connection/db.php"); // database connection
			$this->db 		   	= 	$db; 
			$this->db_user  	= 	$db_user;
	
			}
			
			function if_set_session(){
			
				if(isset($_SESSION['userid'])){


				
					$host = $_SERVER['HTTP_HOST'];
					$uri =rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
					header("LOCATION:http://$host$uri/");
					$userip = $_SERVER['REMOTE_ADDR'];
					$userid = $_SESSION['userid'];
					$d = date("Y-m-d-H-i-s");
					exit;
				}
				
			
			}

}
$logged_in = new logged_in;
$logged_in->if_set_session();
?>