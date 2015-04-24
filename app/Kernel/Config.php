<?php

namespace Kernel;

use Kernel\Decoder\Decoder;

/**
 * @author Dennis Eisele <dennis.eisele@online.de>
 */
class Config
{
	/**
	 *
	 * the function returns the DBConfig.yml as an array
	 *
	 * @return array
	 */
	public static function dbConfig()
	{
		return Decoder::yamlParseFile("Config/DBConfig.yml");
	}

	/**
	 *
	 * the function returns the Routing.yml as an array
	 *
	 * @return array 
	 */
	public static function routing()
	{
		return Decoder::yamlParseFile("Config/Routing.yml");	
	}
	
	/**
	 *
	 * the function returns the securityConfig.yml as an array
	 *
	 * @return array 
	 */	
	public static function securityConfig()
	{
		return Decoder::yamlParseFile("Config/securityConfig.yml");
	}

	/**
	 *
	 * the function returns the srcInit.yml as an array
	 *
	 * @return array
	 */	
	public static function srcInit()
	{
		return Decoder::yamlParseFile("Config/SrcInit.yml");
	}
}