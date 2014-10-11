<?php
namespace Kernel\ConsoleFunctions;

use Kernel\DataBase\DB;
use Config\DBConfig;

class Database
{
	public static function create()
	{
		// init DB
		$db = new DB();
		DBConfig::init();

		foreach(DBConfig::getDatabases() as $key => $value){

			$sql_check = "SHOW DATABASES LIKE '$value'";
			$result = $db::$db->query($sql_check);

			if(!mysqli_num_rows($result) > 0){
				$sql = "CREATE DATABASE $value";
				$db::$db->query($sql) or die($db::$db->error);
			}else{
				echo "The Database '$value' does already exist do you want to replace it\npress y for yes and another for no:";
				$answer = trim(fgets(STDIN));
				if($answer === 'y'){
					$sql = "DROP DATABASE IF EXISTS $value";
					$db::$db->query($sql) or die($db::$db->error);

					$sql = "CREATE DATABASE $value";
					$db::$db->query($sql) or die($db::$db->error);
				}
			}
		}
	}//end function
}