<?php

namespace Kernel\ConsoleFunctions;

use Kernel\DataBase\Database as db;
use Config\DBConfig;
use Config\SrcInit;

class Database
{
	/**
	 *
	 * The createMethod creates the Database which are listed in Config if they doesn't exist or replace the existing if the user accept
	 *
	 * @return void
	 */
	public static function create()
	{
		//init Database
			$db = new db();
			DBConfig::init();
		//check all listed Databases
			foreach(DBConfig::getDatabases() as $key => $value){
				//if database already exist ask if the user want to replace it, else create the Database
					$sqlCheck 	= "SHOW DATABASES LIKE '$value'";
					$result 	= $db::$db->query($sqlCheck);
					if(!mysqli_num_rows($result) > 0){
						//create database
							$sql = "CREATE DATABASE $value";
							$db::$db->query($sql) or die("It went something wrong by creating Database\n");
					}else{
						//replace the existing Databases if the user press 'y'
							echo "The Database '$value' does already exist do you want to replace it\npress y for yes and another for no:";
							$answer = trim(fgets(STDIN));
							if($answer === 'y'){
								//drop existing
									$sql = "DROP DATABASE IF EXISTS $value";
									$db::$db->query($sql) or die("It went something wrong by droping Database maybe you don't have rights \n");
								//create database
									$sql = "CREATE DATABASE $value";
									$db::$db->query($sql) or die("It went something wrong by creating Database\n");
							}
					}
			}
	}

	/**
	 *
	 * The syncMethod syncs the DatabaseTables with the Entitys in srcFolder
	 *
	 * @return void
	 */
	public static function sync()
	{
		//init srcFolders
			SrcInit::init();
		//init Database
			$db = new db();
			DBConfig::init();
		$affected = 0;
		//read entitys from initialized srcFolders
			foreach(SrcInit::getSrcFolder() as $srcFolder){
				//check if there an entityFolder exists in the srcFolder
					if(file_exists('src/'.$srcFolder.'/Entity')){
						//read all files
							$handle = opendir('src/'.$srcFolder.'/Entity'); 
							while(false !== $entityFileName = readdir($handle)){
								if($entityFileName != "." && $entityFileName != ".."){
									//check if Database exists
									    $dbName = DBConfig::getDatabases()['primary'];
									    $sql_check = "SHOW DATABASES LIKE '$dbName'";
										$result = $db::$db->query($sql_check);
									if($result->num_rows > 0){
										//get the entityObject
											$entityName 	= rtrim($entityFileName,'.php');
											$entityObjectNS = '\\src\\'.$srcFolder.'\\Entity\\'.$entityName;
											$entityObject 	= new $entityObjectNS;
										//get the entityObjectArray
											$entityObjectArray = self::getEntityObjectArray($entityObject);
										//check the validity
											self::checkEntityValidity($entityObjectArray, $entityObject);
										//sync the Database with the Entity and increase affected
											$affected += self::syncEntitywithDatabase($entityName, $dbName, $entityObjectArray, $db);
									}else{
										die("\n You have to create the Databases first\n");
									}


								}
							}
						closedir($handle); 
					}
			}
			//echo the endMessage
				if($affected !== 0){
					echo "The Database was updated successfull with $affected changes!\n";
				}else{
					echo "The Database is already up to date!\n";
				}
	}

	/**
	 *
	 * The getEntityObjectArrayMethod calls the EntityObject and conver it in an Array
	 *
	 * @param object $entityObject
	 *
	 * @return array
	 */
	private static function getEntityObjectArray($entityObject)
	{
		//convert in Array
			$entityObjectArray = array();
			foreach((array)$entityObject as $key => $value){
				$key = preg_match('/^\x00(?:.*?)\x00(.+)/', $key, $matches) ? $matches[1] : $key;
				$entityObjectArray[$key] = $value;
			}
		return $entityObjectArray;
	}

	/**
	 *
	 * The checkEntityValidity checks if the Entity is valid
	 *
	 * @param array $entityObjectArray, $entityObject
	 *
	 * @return void
	 */
	private static function checkEntityValidity($entityObjectArray, $entityObject)
	{
		//check if every objectProberty has an setter and getterMethod
			foreach($entityObjectArray as $key => $value){
				if(!method_exists($entityObject,'set'.ucfirst($key)) || !method_exists($entityObject,'get'.ucfirst($key))){
					die("\nYou have an mistake in your Entity: $entityName, because you don't have all setter and getter methods!\n");
				}
			}
	}

	/**
	 *
	 * The syncEntitywithDatabaseMethod syncs the entitys with the Tables in Database
	 *
	 * @param string $entityName, $dbName, $entityObjectArray
	 * @param object $db
	 *
	 * @return int
	 */
	private function syncEntitywithDatabase($entityName, $dbName, $entityObjectArray, $db)
	{
		$affected = 0;
		//check if Table exist
			$sqlCheck ="SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = '$entityName' AND table_schema = '$dbName' ";
			$result = $db::$db->query($sqlCheck);
		//if the Table exists then sync it with the Entity else create it		
			if($result->num_rows > 0){
				$sqlColumns ="SELECT * FROM $dbName.$entityName ";
				$result = $db::$db->query($sqlColumns) or die($db::$db->error);
				$i = 0;
				foreach($entityObjectArray as $key => $value){
					if($i < $result->field_count){
						if($result->fetch_field_direct($i)->name !== strtolower($key)){
							$sqlChangeColumName ="ALTER TABLE $dbName.$entityName change ".$result->fetch_field_direct($i)->name." $key varchar(".$result->fetch_field_direct($i)->length.
								")";
							$db::$db->query($sqlChangeColumName) or die($db::$db->error);
							$affected++;
						}
					}else{
						$sqlNewColumn ="ALTER TABLE $dbName.$entityName ADD $key varchar(100
								)";
						$db::$db->query($sqlNewColumn) or die($db::$db->error);
						$affected++;
					} 
					$i++;
				}
			}else{
				//create Table
					$sql = "CREATE TABLE IF NOT EXISTS $dbName.`$entityName` (\n";
					foreach ($entityObjectArray as $key => $value) {
						if(strtolower($key) == 'id'){
							$sql .= "`id` int(11) NOT NULL AUTO_INCREMENT,\n";
						}else{
							$sql .= "`$key` varchar(100) NOT NULL,\n";
						}
					}
					$sql .= "PRIMARY KEY (`id`) )";
					$db::$db->query($sql) or die($db::$db->error);
			}
			return $affected;
	}
}