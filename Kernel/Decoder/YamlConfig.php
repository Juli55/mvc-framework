<?php

namespace Kernel\Decoder

use Kernle\Decoder\decoder

/**
 * @author Dennis Eisele <dennis.eisele@online.de>
 */

class YamlConfig
{

	/**
	* @var array
	*/
	public static  $routing  		 = array();
	public static  $dbConfig 		 = array();
	public static  $securityConfig	 = array();
	public static  $srcFolder		 = array();

	public static function decodeConfigs()
	{
		self::$dbConfig 		= yamlParseFile("../DBConfig.yml");
		self::$routing  		= yamlParseFile("../Routing.yml");
		self::$securityConfig 	= yamlParseFile("../securityConfig.yml");
		self::$srcFolder		= yamlParseFile("../SrcInit.yml");
	}

}