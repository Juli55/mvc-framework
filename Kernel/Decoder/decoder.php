<?php

namespace Kernel\Decoder;

/**
 * @author Dennis Eisele <dennis.eisele@online.de>
 */

class Decoder
{

	/**
	 *
	 * the function returns a parsed array of a yaml file
	 *
	 * @param String $filename
	 *
	 * @return array
	 */
	
	public static function yamlParseFile($filename)
	{
		return yaml_parse_file($filename);
	}
	
}