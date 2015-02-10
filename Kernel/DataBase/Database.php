<?php

namespace Kernel\DataBase; 

use Config\DBConfig;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 * @author Dennis Eisele  <dennis.eisele@online.de>
 */
class Database
{
	public static $db;
	public static $db_user;

	/**
	 * @return void
	 */
	public function __construct()
	{
		//init DBConfig
			DBConfig::init();
		//set probertyVariables
			$host 	  	= DBConfig::getDbConfig()['host'];
			$username 	= DBConfig::getDbConfig()['username'];
			$password 	= DBConfig::getDbConfig()['password'];
			$databases  = DBConfig::getDatabases();
		//init the DataBase
		self::init($host, $username, $password, $databases);
	}

	/**
	 *
	 * @param String $host,$username,$password
	 * @param Array  $databases
	 *
	 * @return Object
	 */
	private static function init($host, $username, $password, $databases)
	{
		//generate the MySQL-Database Object
			self::$db = new \mysqli($host, $username, $password);
		//throw error, when the connection fails
			if(mysqli_connect_errno()){
			  printf("Verbindung fehlgeschlagen: %s\n", mysqli_connect_error());
			  exit();
			}
		//set the primary DataBase
			self::$db_user = $databases['primary'];

		return self::$db;
	}
}