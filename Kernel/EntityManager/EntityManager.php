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

 	public function create(){




 	}

 	public function find($finder,$target){

 		$query = "SELECT * FROM $this->db_user.$this->entityObject_name WHERE $finder = $target";
 		$request = $this->db->query($query) or die($this->db->error);
 		foreach ($request->fetch_assoc() as $key => $value){

 			$setter = 'set'.ucfirst($key);
 			call_user_func_array(array($this->entityObject,$setter),array($value));

  		}

  		$this->target = $target;
  		$this->finder = $finder;
  		$this->entityFirst = (array)$this->entityObject;
  		return $this->entityObject;

 	}

 	public function findAll($finder='',$target='')
 	{

 		if(empty($finder))
 		{
 			$query = "SELECT * FROM $this->db_user.$this->entityObject_name";
 			$request = $this->db->query($query) or die($this->db->error);
			$result=array();
 			while($row=$request->fetch_assoc())
 			{
 				$result[]=$row;
 			} 
 			return $result;
 		}
 		else{

 			$query = "SELECT * FROM $this->db_user.$this->entityObject_name WHERE $finder = $target";
 			$request = $this->db->query($query) or die($this->db->error);
 			while($row=$request->fetch_assoc())
 			{
 				$result[]=$row;
 			}
 				foreach ($result as $key => $value) {
 			 		foreach ($value as $key => $val){

 			 			$setter = 'set'.ucfirst($key);
 						call_user_func_array(array($this->entityObject,$setter),array($val));
 					}
 			 	}

 			$this->target = $target;
 			$this->finder = $finder;
  			$this->entityFirst = (array)$this->entityObject;
  			return $this->entityObject;

 		}	   
  			
  		
 	}

 	public function flush($entity){

 		$arr = $this->entityFirst;
  		$arr2= (array)$entity;
   		foreach ($arr2 as $key => $val) {

  			if($val !== $arr[$key])
  			{
  				echo "joho";
  				$column_ltrim = ltrim($key);
  			    $column_ltrim2= ltrim($column_ltrim,$this->entityObject_name);
  				$column_ltrim3= ltrim($column_ltrim2);
  				$arr =
  				echo $this->query = "UPDATE $this->db_user.$this->entityObject_name SET $column_ltrim3 = $arr2[$key] WHERE $ID = $arr[userID] ";
 		   		$request = $this->db->query($this->query) or die($this->db->error);
  			}
			
  		} 		


 	}

}