<?php

namespace Kernel\Decoder;

/**
 * @author Dennis Eisele <dennis.eisele@online.de>
 */

class Decoder
{

	/**
	* @var array
	*/
	public static $parsedArray;
	
	public static function yamlParseFile($filename)
	{
		return self::$parsedArray = yaml_parse($filename);
	}
	
}