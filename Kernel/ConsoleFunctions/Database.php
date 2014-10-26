<?php
namespace Kernel\ConsoleFunctions;

use Kernel\DataBase\DB;
use Config\DBConfig;
use Config\SrcInit;

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

	public static function sync()
	{
		// init srcFolders
			SrcInit::init();
		// init DB
			$db = new DB();
			DBConfig::init();

		$affected = 0;
		// read entitys from initialized srcFolders
			foreach(SrcInit::getSrcFolder() as $srcFolder){
				if(file_exists('src/'.$srcFolder.'/Entity')){
					$handle = opendir ('src/'.$srcFolder.'/Entity'); 
					while (false !== $entityFile = readdir($handle)) {

						if ($entityFile != "." && $entityFile != "..") {
				        	
				        	$entityName =  rtrim($entityFile,'.php');
				        	$entityObjectNS =  '\\src\\'.$srcFolder.'\\Entity\\'.$entityName;
				        	$entityObject = new $entityObjectNS;

				        	// check if every Variable has a setter and getter method
				        		$entityObjectClean = array();
				        		foreach ((array)$entityObject as $key => $value){
							        $key = preg_match('/^\x00(?:.*?)\x00(.+)/', $key, $matches) ? $matches[1] : $key;
							        $entityObjectClean[$key] = $value;
							    }
							    foreach ($entityObjectClean as $key => $value) {
							    	if(!method_exists($entityObject,'set'.ucfirst($key)) || !method_exists($entityObject,'get'.ucfirst($key))){
							    		die("\nYou have an mistake in your Entity: $entityName, because you don't have all setter and getter methods!\n");
							    	}
							    }
							// check if database exists
							    $dbName = DBConfig::getDatabases()['primary'];
							    $sql_check = "SHOW DATABASES LIKE '$dbName'";
								$result = $db::$db->query($sql_check);
								if(mysqli_num_rows($result) > 0){
								    
								    	// check if database table exist
								    		$sql_check ="SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '$entityName' AND table_schema = '$dbName' ";
								    		$result = $db::$db->query($sql_check);
								    		
								    		if($result->num_rows > 0)
											{
												$sql_columns ="SELECT * FROM $dbName.$entityName ";
												$result = $db::$db->query($sql_columns) or die($db::$db->error);
												$i = 0;

												foreach ($entityObjectClean as $key => $value) {
									    			if($i < $result->field_count){
									    				if($result->fetch_field_direct($i)->name !== strtolower($key)){
									    					$sql_change_columnname ="ALTER TABLE $dbName.$entityName change ".$result->fetch_field_direct($i)->name." $key varchar(".$result->fetch_field_direct($i)->length.
										    					")";
										    				$db::$db->query($sql_change_columnname) or die($db::$db->error);
										    				$affected++;
									    				}
									    			}else{
									    				$sql_new_column ="ALTER TABLE $dbName.$entityName ADD $key varchar(100
										    					)";
										    			$db::$db->query($sql_new_column) or die($db::$db->error);
										    			$affected++;
									    			} 
									    			$i++;
									    		}
											}else{

												$sql = "CREATE TABLE IF NOT EXISTS $dbName.`$entityName` (\n";
												foreach ($entityObjectClean as $key => $value) {
													if(strtolower($key) == 'id'){
														$sql .= "`id` int(11) NOT NULL AUTO_INCREMENT,\n";
													}else{
														$sql .= "`$key` varchar(100) NOT NULL,\n";
													}
												}
												$sql .= "PRIMARY KEY (`id`) )";
									    		$db::$db->query($sql) or die($db::$db->error);
											}
								    
								}else{
									die("\n You have to create the Databases first\n");
								}


				        }
					}
					closedir($handle); 
				}
			}
			if($affected !== 0){
				echo "The Database was updated successfull with $affected changes!\n";
			}else{
				echo "The Database is already up to date!\n";
			}
	}
}