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

	/** 
     * @var object
     */
	private $entityFirst;
	

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

  		}

  		$this->entityFirst = (array)$this->entityObject;
  		return $this->entityObject;

 	}


 	public function flush($entity){

 		$arr = (array)$this->entityFirst;
  		$arr2= (array)$entity;
  		$ID = $arr["[userID]"]; 
  		foreach ($arr as $key => $val) {

  			if($val !== $arr2[$key])
  			{
  				$column = str_replace($this->entityObject_name,"",$key);
  				$column_ltrim = ltrim($column);
  				$this->query = "UPDATE $this->db_user.$this->entityObject_name SET $column_ltrim = $arr2[$key] WHERE ID = $ID ";
 		   		$request = $this->db->query($this->query) or die($this->db->error);
  			}
			
  		} 		


 	}

}