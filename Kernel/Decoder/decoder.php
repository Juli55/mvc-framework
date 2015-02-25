<?php

namespace Kernel\Decoder;

/**
 * @author Dennis Eisele <dennis.eisele@online.de>
 */

class Decoder
{
	
	public static function yamlParseFile($filename)
	{
		return $parsedArray = yaml_parse_file($filename);
	}
	
}