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
	

	function __construct(){

        $db = new DB;
		
	}

	public function getConnection(){

		return $this->db;

	}
 	
 	public function getEntity($entity){

 		$entityDir = explode(':',$entity);

 		include('src/'.$entityDir[0].'/Entity/'.$entityDir[1].'.php');

 		$entityObject = new $entityDir[1];

 		return $entityObject;

 	}

 	public function find($finder,$target){

 		

 	}


 	public function flush($entity){


 	}

}