<?php

namespace Kernel\DataBase; 

use Kernel\Config;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 * @author Dennis Eisele  <dennis.eisele@online.de>
 */
class Database
{
	/**
	 * @var mysqli
	 */
	public static $db;

	/**
	 * @var string
	 */
	public static $dbUser;

	/**
	 *
	 * The Constructor sets the dbConfigs and inits the DataBase
	 *
	 * @return void
	 */
	public function __construct()
	{
		//set probertyVariables
			$host 	  	= Config::dbConfig()['host'];
			$username 	= Config::dbConfig()['username'];
			$password 	= Config::dbConfig()['password'];
			$databases  = Config::dbConfig()['databases'];
		//init the DataBase
		self::init($host, $username, $password, $databases);
	}

	/**
	 *
	 * The init Function generates the DatabaseObject, sets the dbUser and returns this Object
	 *
	 * @param string $host,$username,$password
	 * @param Array  $databases
	 *
	 * @return object
	 */
	private static function init($host, $username, $password, $databases)
	{
		//generate the MySQLi-Database Object
			$db = new \mysqli($host, $username, $password);
			self::$db = $db;
		//throw error, when the connection fails
			if(mysqli_connect_errno()){
			  printf("Verbindung fehlgeschlagen: %s\n", mysqli_connect_error());
			  exit();
			}
		//set the primary DataBase
			self::$dbUser = $databases['primary'];

		return $db;
	}
}
