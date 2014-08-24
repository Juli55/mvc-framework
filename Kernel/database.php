<?php

namespace Kernel;


class DB_MySQL
{
 	/**
	 * @var Database-Object
	 */
	public static $db;

	public static function init($host, $database, $user, $pass)
	{
		self::$db = connect($host, $database, $user, $pass);
		if(self::$db->connect_errno){
			die( 'Es konnte keine Verbindung zur Datenbank hergestellt werden!'); 
		}
	}
	public static function connect($host, $database, $user, $pass)
	{
		self::$db = new mysqli($host,$user,$pass);
	}
 
 	public static function disconnect()
 	{
    	if (is_resource($this->connection)) {
    		mysql_close($this->connection);
   		}
	}
}