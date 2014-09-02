<<<<<<< HEAD
<?php 

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 * @author Dennis Eisele  <dennis.eisele@online.de>
 */
Class DB
{
	public static $db;
	public static $db_user;

	function __construct()
	{
		self::init('localhost', 'root', '');
	}

	private static function init($host, $username, $password)
	{
		self::$db = new mysqli($host, $username, $password);

		if (mysqli_connect_errno()) {
		  printf("Verbindung fehlgeschlagen: %s\n", mysqli_connect_error());
		  exit();
		}

		self::$db_user = "projectify";
		return self::$db;
	}
}
?>  
=======
<?php 

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 * @author Dennis Eisele  <dennis.eisele@online.de>
 */

Class DB
{

	public static $db;

	public static $db_user;


	function __construct()

	{

		self::init('localhost', 'root', '');

	}


	private static function init($host, $username, $password)

	{

		self::$db = new mysqli($host, $username, $password);


		if (mysqli_connect_errno()) {

		  printf("Verbindung fehlgeschlagen: %s\n", mysqli_connect_error());

		  exit();

		}


		self::$db_user = "projectify";

		return self::$db;

	}

}
>>>>>>> remotes/origin/routing
