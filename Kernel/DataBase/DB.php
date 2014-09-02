<?php 

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
Class DB
{
	public static $db;

	function __construct()
	{
		self::init('localhost', 'root', '');
	}

	private function init($host, $username, $password)
	{
		self::$db = new mysqli($host, $username, $password);

		if (mysqli_connect_errno()) {
		  printf("Verbindung fehlgeschlagen: %s\n", mysqli_connect_error());
		  exit();
		}

		self::$db->close();
	}
}