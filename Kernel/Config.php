<?php

namespace Kernel;

use Kernel\Decoder\Decoder;

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
		return self::$dbConfig 		= Decoder::yamlParseFile("../DBConfig.yml");
	}

	public static function routing()
	{
		return self::$routing  		= Decoder::yamlParseFile("../Routing.yml");	
	}

	public static function securityConfig()
	{
		return self::$securityConfig = Decoder::yamlParseFile("../securityConfig.yml");
	}
	
	public static function srcInit()
	{
		return self::$srcFolder		= Decoder::yamlParseFile("../SrcInit.yml");
	}
}