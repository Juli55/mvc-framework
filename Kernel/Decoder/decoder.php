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
	private $parsedArray = array();
	
	public static function yamlParseFile($filename)
	{
		return $parsedArray = yaml_parse($filename);
	}
	
}