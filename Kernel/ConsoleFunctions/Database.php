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

		// read entitys from initialized srcFolders
			foreach(SrcInit::getSrcFolder() as $srcFolder){
				if(file_exists('src/'.$srcFolder.'/Entity')){
					$handle = opendir ('src/'.$srcFolder.'/Entity'); 
					while (false !== $entityFile = readdir($handle)) {

						if ($entityFile != "." && $entityFile != "..") {
				        	
				        	include 'src/'.$srcFolder.'/Entity/'.$entityFile;
				        	$entityName =  rtrim($entityFile,'.php');
				        	$entityObject = new $entityName;

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
												foreach ($entityObjectClean as $key => $value) {
									    			echo $key;
									    		}
											}else{
												$sql = "CREATE TABLE IF NOT EXISTS $dbName.`$entityName` (
	 
														`id` int(11) NOT NULL AUTO_INCREMENT,
	 
														`name` varchar(100) NOT NULL,
	 
														`email` varchar(150) NOT NULL,
	 
														`address` varchar(255) NOT NULL,
	 
														`mob` varchar(15) NOT NULL,
	 
														PRIMARY KEY (`id`)
	 
														)";
									    		$db::$db->query($sql) or die($db::$db->error);
											}
											/*
									    	if(mysqli_num_rows($result) > 0){
									    		//echo "hey";
									    		foreach ($entityObjectClean as $key => $value) {
									    			
									    		}
								    		}else{
								    			$sql = "CREATE TABLE IF NOT EXISTS $dbName.`userese` (
	 
														`id` int(11) NOT NULL AUTO_INCREMENT,
	 
														`name` varchar(100) NOT NULL,
	 
														`email` varchar(150) NOT NULL,
	 
														`address` varchar(255) NOT NULL,
	 
														`mob` varchar(15) NOT NULL,
	 
														PRIMARY KEY (`id`)
	 
														)";
									    		$db::$db->query($sql) or die($db::$db->error);
								    			foreach ($entityObjectClean as $key => $value) {

									    		}
								    		}
								    		*/
								    
								}else{
									die("\n You have to create the Databases first\n");
								}


				        }
					}
					closedir($handle); 
				}
			}
	}
}