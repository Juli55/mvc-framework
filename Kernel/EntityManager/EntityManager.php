<?php

namespace Kernel\EntityManager;

use Kernel\DataBase\DB;

/**
 * @author Dennis Eisele  <dennis.eisele@online.de>
 */
class EntityManager{

	/** 
     * @var DB 
     */
	private $db;

	/** 
     * @var DB 
     */
	private $db_user;

	/** 
     * @var string
     */
	private $entityObject_name;

	/** 
     * @var object
     */
	private $entityObject;
	

	function __construct(){

        $db = new DB;
        $this->db  = $db::$db;
        $this->db_user  = $db::$db_user;
		
	}

	public function getConnection(){

		return $this->db;

	}
 	
 	public function getEntity($entity){

 		$entityDir = explode(':',$entity);

 		require('../src/'.$entityDir[0].'/Entity/'.$entityDir[1].'.php');

 		$entityObject = new $entityDir[1];

 		$this->entityObject_name = get_class($entityObject);
 		$this->entityObject = $entityObject;
 		return $entityObject;

 	}

 	public function find($finder,$target){

 		$query = "SELECT * FROM $this->db_user.$this->entityObject_name WHERE $finder = $target";
 		$request = $this->db->query($query) or die($this->db->error);
 		foreach ($request->fetch_assoc() as $key => $value){

 			$setter = 'set'.ucfirst($key);
 			call_user_func_array(array($this->entityObject,$setter),array($value));
 			$getter = 'get'.ucfirst($key);
 			call_user_func_array(array($this->entityObject,$getter),array($value));
  		}

  		return $this->entityObject;

 	}


 	public function flush($entity){



 	}

}