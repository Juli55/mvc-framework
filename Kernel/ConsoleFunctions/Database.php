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
			    //252 is currently mapped to all text and blob types (MySQL 5.0.51a)
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
								if($entityName != "." && $entityName != ".."){
									if(self::tableExist($db, $entityName)){
										//get DatabaseFields Data
											$entityFieldsData = self::getEntityFieldsData($entityObject);
										//get EntityFields Data
											$dbFieldsData = self::getEntityFieldsData($dbName, $entityName);
										//add changes
											$changes[$entityName] = self::getChanges($entityFieldsData);
									}else{
										$new[] = $entityFieldsData;
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
	 * @param object $db
	 *
	 * @return array
	 */
	private static function getDbFieldsData($db, $table)
	{
		//check the exist
			$result = $db::$db->query("SHOW TABLES LIKE $db::$dbUser.$table");
	  		$exist 	= $result->num_rows > 0;
		return $exist;
	}

	/**
	 *
	 * @param string $dbName, $entityName
	 *
	 * @return array
	 */
	private static function getDbFieldsData($dbName, $entityName)
	{
		//get the dbTable
			$sqlColumns ="SELECT * FROM $dbName.$entityName ";
			$result = $db::$db->query($sql_columns) or die($db::$db->error);
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
	public static function getEntityFieldsData($entityObject)
	{
		//generate the Clean EntityObject
			$entityObjectClean = array();
			foreach ((array)$entityObject as $key => $value){
				$key = preg_match('/^\x00(?:.*?)\x00(.+)/', $key, $matches) ? $matches[1] : $key;
				$entityObjectClean[$key] = $value;
			}
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
							$entityField[$akey] = $probertys;
					}
					$entityFields[$key] = $entityField;
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
			foreach($entity as $key => $value){
				if(isset($dbTable[$key])){
					//add different probertys
						foreach($value => $probertyKey){
							//check if different
								if($value[$probertyKey] !== $dbTable[$key][$probertyKey]){
									$changes['proberty'][$key][$probertyKey] = $value[$probertyKey];
								}
						}
					//delete entry from Array
						unset($dbTable[$key]);
				}else{
					//take probertys from new fields
						$changes['new'][$key]['type'] = $value['type'];
						$changes['new'][$key]['length'] = $value['length'];
						if(isset($value['auto_increment'])){
							$changes['new'][$key]['auto_increment'] = true;
						}
				}
			//add rest entrys to delete
				foreach($dbTable => $field){
					$changes['delete'][] = $field;
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
	public static function takeChanges()
	{

	}

	//check if Database exists
	    $dbName = Config::dbConfig()['primary'];
	    $sql_check = "SHOW DATABASES LIKE '$dbName'";
		$result = $db::$db->query($sql_check);
	if($result->num_rows > 0){
		
	}else{
		die("\n You have to create the Databases first\n");
	}
	
}