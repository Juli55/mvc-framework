<?php

namespace Config;

/**
 * @author Julian Bertsch <Julian.bertch42@gmail.com>
 */
class DBConfig
{
	/**
	 * @var array
	 */
	private static $dbConfig  = array();
	private static $databases = array();

	/**
	 * @return void
	 */
	public static function init()
	{
		self::$dbConfig = array(
							'host'		=>	'localhost',
							'username'	=>	'root',
							'password'	=>	'',
						);
		self::$databases = array(
							'primary' => 'projectify',
							'img'
						);
	}

	/**
	 * @return array
	 */
	public static function getDbConfig()
	{
		return self::$dbConfig;
	}

	/**
	 * @return array
	 */
	public static function getDatabases()
	{
		return self::$databases;
	}
}
