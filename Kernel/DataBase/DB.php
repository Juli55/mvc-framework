<?php

namespace Kernel\DataBase; 

use Config\DBConfig;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 * @author Dennis Eisele  <dennis.eisele@online.de>
 */

Class DB
{

	public static $db;

	public static $db_user;


	public function __construct()
	{
		DBConfig::init();

		$host 	  = DBConfig::getDbConfig()['host'];
		$username = DBConfig::getDbConfig()['username'];
		$password = DBConfig::getDbConfig()['password'];

		$databases = DBConfig::getDatabases();

		self::init($host, $username, $password, $databases);
	}


	private static function init($host, $username, $password, $databases)
	{

		self::$db = new \mysqli($host, $username, $password);


		if (mysqli_connect_errno()) {

		  printf("Verbindung fehlgeschlagen: %s\n", mysqli_connect_error());

		  exit();

		}

		self::$db_user = $databases['primary'];

		return self::$db;
	}
}