<?php

namespace Kernel\ConsoleFunctions;

use Kernel\DataBase\Database as db;
use Kernel\Config;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 * @author Dennis Eisele  <dennis.eisele@online.de>
 */
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
			Config::dbConfig();
		//check all listed Databases
			foreach(Config::dbConfig() as $key => $value){
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
		//init db
			$db = new db();
			$affected = 0;
		//init variables
			$entityFieldsData 	= array();
			$dbFieldsData 		= array();
			$changes  			= array();
			$new 				= array();
			$mysqlDataTypeHash  = array(
			    1=>'tinyint',
			    2=>'smallint',
			    3=>'int',
			    4=>'float',
			    5=>'double',
			    7=>'timestamp',
			    8=>'bigint',
			    9=>'mediumint',
			    10=>'date',
			    11=>'time',
			    12=>'datetime',
			    13=>'year',
			    16=>'bit',
			    252=>'varchar',
			    253=>'varchar',
			    254=>'char',
			    246=>'decimal'
			);
		//read entitys from initialized srcFolders
			foreach(Config::srcInit() as $srcFolder){
				//check if there an entityFolder exists in the srcFolder
					if(file_exists('src/'.$srcFolder.'/Entity')){
						//read all files
							$handle = opendir('src/'.$srcFolder.'/Entity'); 
							while(false !== $entityFileName = readdir($handle)){
								if($entityFileName != "." && $entityFileName != ".."){
									//call entity Object
										$entityName =  rtrim($entityFileName,'.php');
							        	$entityObjectNS =  '\\src\\'.$srcFolder.'\\Entity\\'.$entityName;
							        	$entityObject = new $entityObjectNS;
									if(self::tableExist($db, $entityName)){
										//get DatabaseFields Data
											$entityFieldsData[$entityName] = self::getEntityFieldsData($entityObject, $entityObjectNS);
										//get EntityFields Data
											$dbFieldsData[$entityName] = self::getDbFieldsData($db, $entityName, $mysqlDataTypeHash);
										//add changes
											$changes[$entityName] = self::getChanges($entityFieldsData[$entityName], $dbFieldsData[$entityName]);
									}else{
										$new[] = $entityFieldsData[$entityName];
									}
								}
							}
						closedir($handle); 
					}
			}
			self::takeChanges($changes, $new, $db);
			//echo the endMessage
				if($affected !== 0){
					echo "The Database was updated successfull with $affected changes!\n";
				}else{
					echo "The Database is already up to date!\n";
				}
	}

	/**
	 *
	 * @param object $db
	 *
	 * @return array
	 */
	private static function tableExist($db, $table)
	{
		//check the exist
			$dbName = $db::$dbUser;
			$result = $db::$db->query("SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$dbName' AND TABLE_NAME = '$table'")or die ($db::$db->error);
	  		$exist 	= $result->num_rows;
		return $exist;
	}

	/**
	 *
	 * @param string $dbName, $entityName
	 *
	 * @return array
	 */
	private static function getDbFieldsData($db, $entityName, $mysqlDataTypeHash)
	{
		//get the dbTable
			$dbName = $db::$dbUser;
			$sqlColumns ="SELECT * FROM $dbName.$entityName ";
			$result = $db::$db->query($sqlColumns) or die($db::$db->error);
		//get the fieldprobertys and fill it in the dbFieldsArray
			while ($column = $result->fetch_field()) {
				//init probertys array
					$probertys = array();
				//fill the array
					$probertys['type'] 	 =  $mysqlDataTypeHash[$column->type];
					$probertys['length'] =  $column->max_length;
				//put the probertysArray in the dbFieldsArray
					$dbFields[$column->name] = $probertys;
			}
		return $dbFields;
	}

	/**
	 *
	 * 
	 *
	 * @return void
	 */
	public static function getEntityFieldsData($entityObject, $entityNamespace)
	{
		//generate the Clean EntityObject
			$entityObjectClean = array();
			foreach ((array)$entityObject as $key => $value){
				$key = preg_match('/^\x00(?:.*?)\x00(.+)/', $key, $matches) ? $matches[1] : $key;
				$entityObjectClean[$key] = $value;
			}
		$reflectionClass = new \ReflectionClass($entityNamespace);
		//foreach the EntityObject to get all Fields
			foreach ($entityObjectClean as $key => $value) {						
				//generate an array of the Annotationprobertys
					$reflectedProperty = $reflectionClass->getProperty($key);
					$propertyDocumentation = $reflectedProperty->getDocComment();
					preg_match_all('/@prob\(.*\)/', $propertyDocumentation, $typeAnnotation);
				//set an array for the probertys and set standarts
					$probertys = array('type' => 'varchar');
				//foreach the AnnotationprobertyArray to get the Probertys
					foreach($typeAnnotation[0] as $probAnnotation){
						//remove the patternSyntax to get the key and value
							$prob = ltrim($probAnnotation,'@prob');
							$prob = ltrim($prob,'(');
							$prob = rtrim($prob,')');
							$prob = explode('=',$prob);
							$akey   = trim(trim($prob[0]),"'");
							$avalue = $prob[1];
						//add probertys to the Array
							$probertys[$akey] = trim($avalue);
					}
					$entityFields[$key] = $probertys;
			}
		return $entityFields;
	}

	/**
	 *
	 * 
	 *
	 * @return void
	 */
	public static function getChanges($entity, $dbTable)
	{
		//init changesArray
			$changes = array();
		//compare EntityFields with exist DatabaseFields
			foreach($entity as $fieldName => $value){
				if(isset($dbTable[$fieldName])){
					//add different probertys
						foreach($value as $probertyKey => $probertyValue){
							//check if different
								if(isset($dbTable[$fieldName][$probertyKey])){
									if($probertyValue !== $dbTable[$fieldName][$probertyKey]){
										$changes['proberty'][$fieldName][$probertyKey] = $probertyValue;
									}
								}
						}
					//delete entry from Array
						unset($dbTable[$fieldName]);
				}else{
					//take probertys from new fields
						$changes['new'][$fieldName]['type'] = $value['type'];
						$changes['new'][$fieldName]['length'] = $value['length'];
						if(isset($value['auto_increment'])){
							$changes['new'][$fieldName]['auto_increment'] = true;
						}
				}
			}
			//add rest entrys to delete
				if(isset($dbTable)){
					foreach($dbTable as $fieldName => $fieldProbertys){
						$changes['delete'][] = $fieldName;
					}
				}
		return $changes;
	}

	/**
	 *
	 * 
	 *
	 * @return void
	 */
	public static function takeChanges($changes, $new, $db)
	{
		//init dbUser
			$dbUser = $db::$dbUser;
		//sync existing Tables with Entity
			foreach($changes as $entityName => $entityChangeData){
				//init queryArray
					$queryArray = array();
				if(isset($entityChangeData['delete'])){
					foreach($entityChangeData['delete'] as $fieldName){
						//add delete
							$queryArray[] = "ALTER TABLE $dbUser.$entityName DROP COLUMN $fieldName";
					}
				}
				if(isset($entityChangeData['new'])){
					foreach($entityChangeData['new'] as $fieldName => $field){
						//init probertys
							if(isset($field['type'])){
								$type = $field['type'];
							}else{
								$type = 'varchar';
							}
							if(isset($field['length'])){
								$length = $field['length'];
							}else{
								$length = 255;
							}	
						//add new fields
							$queryArray[] = "ALTER TABLE $dbUser.$entityName ADD $fieldName $type($length)";
					}
				}
				foreach($entityChangeData['proberty'] as $fieldName => $field){
					//init probertys
						if(isset($field['type'])){
							$type = $field['type'];
						}else{
							$type = 'varchar';
						}
						if(isset($field['length'])){
							$length = $field['length'];
						}else{
							$length = 255;
						}		
					//add modify probertys
						$queryArray[] = "ALTER TABLE $dbUser.$entityName MODIFY $type($length)";
				}
				//update Database
					foreach ($queryArray as $query){
						$db::$db->query($query);
					}
			}
		//create Table
			if(!empty($new)){
				foreach($new as $tableName => $columns){
					$sql = "CREATE TABLE IF NOT EXISTS $db::$dbUser.`$entityName` (\n";
					foreach ($columns as $fieldName => $fieldValue) {
						if(strtolower($fieldName) == 'id'){
							$sql .= "`id` int(11) NOT NULL AUTO_INCREMENT,\n";
							$sql .= "PRIMARY KEY (`id`) )";
						}else{
							if(isset($field['type'])){
								$type = $field['type'];
							}else{
								$type = 'varchar';
							}
							if(isset($field['length'])){
								$length = $field['length'];
							}else{
								$length = 255;
							}
							$sql .= "`$fieldName` varchar(100) NOT NULL,\n";
						}
					}
				}
				$db::$db->query($sql) or die($db::$db->error);
			}
	}
}