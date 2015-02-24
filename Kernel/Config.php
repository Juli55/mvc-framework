<?php

namespace Kernel\Decoder;

use Kernle\Decoder\decoder;

/**
 * @author Dennis Eisele <dennis.eisele@online.de>
 */

class Config
{

	/**
	* @var array
	*/
	public static  $routing  		 = array();
	public static  $dbConfig 		 = array();
	public static  $securityConfig	 = array();
	public static  $srcFolder		 = array();

	public static function dbConfig()
	{
		return self::$dbConfig 		= yamlParseFile("../DBConfig.yml");
	}

	public static function Routing()
	{
		return self::$routing  		= yamlParseFile("../Routing.yml");	
	}

	public static function securityConfig()
	{
		return self::$securityConfig = yamlParseFile("../securityConfig.yml");
	}
	
	public static function srcInit()
	{
		return self::$srcFolder		= yamlParseFile("../SrcInit.yml");
	}
}