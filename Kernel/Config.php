<?php

namespace Kernel;

use Kernel\Decoder\Decoder;

/**
 * @author Dennis Eisele <dennis.eisele@online.de>
 */

class Config
{

	public static function dbConfig()
	{
		return $dbConfig 		= Decoder::yamlParseFile("../Config/DBConfig.yml");
	}

	public static function routing()
	{
		return $routing  		= Decoder::yamlParseFile("../Config/Routing.yml");	
	}

	public static function securityConfig()
	{
		return $securityConfig = Decoder::yamlParseFile("../Config/securityConfig.yml");
	}
	
	public static function srcInit()
	{
		return $srcFolder		= Decoder::yamlParseFile("../Config/SrcInit.yml");
	}
}