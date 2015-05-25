<?php

namespace Kernel\EntityManager;

use Kernel\DataBase\Database;

/**
 * @author Dennis Eisele  <dennis.eisele@online.de>
 * @author Julian Bertsch <Julian.Bertsch42@gmail.com>
 */
class EntityManager
{
	/**
	 * @var Database
	 */
	private $db;

	/** 
	 * @var string 
	 */
	private $dbUser;

	/** 
	 * @var string
	 */
	private $entityObjectName;

	/** 
	 * @var object
	 */
	private $entityObject;

	/** 
	 * @var object
	 */
	private $entityFirst;

	/**
	 *
	 * The Constructor creates the DatabaseConnection
	 *
	 * @return void
	 */
	public function __construct()
	{
		//create the DatabaseConnection
			$db = new Database;
			$this->db  = $db::$db;
			$this->dbUser  = $db::$dbUser;
	}

	/**
	 * 
	 * The cleanEntityObject parses an entiyObject in an array and cleans the keys and values
	 *
	 * @param object $entityObject
	 *
	 * @return array
	 */
	private function cleanEntityObject($entityObject)
	{
		foreach ((array)$entityObject as $key => $value){
			$key = preg_match('/^\x00(?:.*?)\x00(.+)/', $key, $matches) ? $matches[1] : $key;
			$cleanEntityArray[$key] = $value;
		}
		return $cleanEntityArray;
	}

	/**
	 *
	 * The getConnection function returns the DatabaseObject
	 *
	 * @return Database
	 */
	public function getConnection()
	{
		return $this->db;
	}

	/**
	 *
	 * The getEntity Function gets the entityShortcut, generate the EntityObject and give this Object back
	 *
	 * @param string $entityShortcut
	 *
	 * @return object
	 */
	public function getEntity($entityShortcut)
	{
		//generate the entityObject
			$entityDir = explode(':',$entityShortcut);
			$entityObjectNS =  '\\src\\'.$entityDir[0].'\\Entity\\'.$entityDir[1];
			$entityObject = new $entityObjectNS;
			$this->entityObjectName =  $entityDir[1];
			$this->entityObject = $entityObject;
		return $entityObject;
	}

	/**
	 *
	 * The find Function get the Values from dbEntry,
	 * if there is an entry the function fills it in the entityObject and returns this Object, else it returns false
	 *
	 * @param string $finder, $target
	 *
	 * @return false,object
	 */
	public function find($finder,$target)
	{
		//get the dbEntry
			$query = "SELECT * FROM $this->dbUser.$this->entityObjectName WHERE $finder = '$target'";
			$request = $this->db->query($query) or 
				//throw exception
					die($this->db->error);
		//if an entry exist, then fill the entityObject with this Values and return this Object
			if($request->num_rows){
				
				foreach ($request->fetch_assoc() as $key => $value){

					$setter = 'set'.ucfirst($key);
					call_user_func_array(array($this->entityObject,$setter),array($value));
				}
				$this->entityFirst = $this->cleanEntityObject($this->entityObject);
				return $this->entityObject;
			}
			return false;	
	}

	/**
	 *
	 * The findAll Function gets all dbEntrys from a Request and saves it in Arrays with EntityObjects
	 *
	 * @param string $finder, $target
	 *
	 * @return object
	 */
	public function findAll($finder = '',$target = '')
	{
		//get the dbEntry
			$query = "SELECT * FROM $this->dbUser.$this->entityObjectName";
			if(!empty($finder)){
			
				$query .= " WHERE $finder = '$target'";
			}
			$request = $this->db->query($query) or die($this->db->error);
		//init the required entityObject Arrays
			$cleanEntityObject  = array();
			$entityFirst  		= array();
			$entityObject 		= array();
		//fill the entityObject Arrays
			while($row = $request->fetch_assoc()){
				//generate an Object with the Values from the dbEntry
					$clonedEntityObject = clone $this->entityObject;
					foreach ($row as $key => $value){
						$setter = 'set'.ucfirst($key);
						call_user_func_array(array($clonedEntityObject,$setter),array($value));
					}
				//fill the entityObject Arrays
					$entityFirst[]  = $this->cleanEntityObject($clonedEntityObject);
					$entityObject[] = $clonedEntityObject;
			}
		//set the objectProbertys
			$this->entityFirst  = $entityFirst;
			$this->entityObject = $entityObject;
		return $entityObject;      
	}

	/**
	 *
	 * The persist Function gets the updatet entityObject, generates an queryString and sets the queryVariable 
	 *
	 * @param object $entity
	 *
	 * @return void
	 */
	public function persist($entity)
	{
		//generate a clean EntityArray
			$cleanEntityObject = $this->cleanEntityObject($entity);
		//generate an String for all Values and an String for all Keys to set a INSERT Query
			$allKeys   = '';
			$allValues = '';
			foreach ($cleanEntityObject as $key => $value){
				if(is_null($value)){
					$value = '0'; 
				}

				if(is_int($value)){
					$value = (string)$value;
				}
				$allValues = $allValues.","."'".$value."'";
				$allKeys = $allKeys.",".$key;
				$allValues = ltrim($allValues,',');
				$allKeys = ltrim($allKeys,',');
			}
		//set the queryVariable
			$this->query = "INSERT INTO $this->dbUser.$this->entityObjectName($allKeys) VALUES($allValues)";
	}

	/**
	 *
	 * The flush Function updates the database with the requiered changes or insert an new entry
	 *
	 * @return void
	 */
	public function flush()
	{
		//init the entityFirst
			$entityFirst = $this->entityFirst;
		if(!empty($this->query)){
			//when the query isn't empty then it creates an new dbEntry
				//send the request
					$this->db->query($this->query) or die ('It went something wrong with the DataBase');
		}elseif(is_object($this->entityObject)){
			//when it is an object, then it is one Entity to update in the database
				//parse the entityObject in an Array and update the changes in database
					$cleanEntityObject = $this->cleanEntityObject($this->entityObject);
					foreach ($cleanEntityObject as $key => $value){          
						if($value !== $entityFirst[$key]){
							$query = "UPDATE $this->db_user.$this->entityObjectName SET $key = '$cleanEntityObject[$key]' WHERE ID = $cleanEntityObject[ID] ";
							$request = $this->db->query($query) or die('It went something wrong with the DataBase');
						}
					}     
		}elseif(is_array($this->entityObject)){
			//when it is an array, then it has more then one entity to update the database
				//parse every entityObjects in Arrays and save it in an 2dimensional Array then UPDATE all changes
					$entityObject = array();
					foreach($this->entityObject as $key => $value){

						$entityObject[] = $this->cleanEntityObject($value);
					}
					foreach ($entityFirst as $key => $value){
						foreach($value as $key2 => $value2){
							if($value2 !== $entityObject[$key][$key2]){
								$query = "UPDATE $this->db_user.$this->entityObjectName SET $key2 = '".$entityObject[$key][$key2]."' WHERE ID = ".$value['ID'];
								$request = $this->db->query($query) or die('It went something wrong with the DataBase');
							}
						}
					}           
		}
	}
}