<?php

namespace Kernel\EntityManager; 

/**
 * @author Dennis Eisele  <dennis.eisele@online.de>
 */

class EntityManager{
	

	function __construct(Connection $conn, Configuration $config, EventManager $eventManager){

		$this->conn              = $conn;
        $this->config            = $config;
        $this->eventManager      = $eventManager;

		

	}

	public function getConnection(){

		return $this->conn = $conn;

	}

	public function createQuery(){
		
	}

}
?>