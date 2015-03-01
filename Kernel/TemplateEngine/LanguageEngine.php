<?php

namespace Kernel\LanguageEngine;

use Kernel\Decoder\Decoder;

/**
 * @author Dennis Eisele <dennis.eisele@online.de>
 */
 class LanguageEngine
 {
 	/**
 	 * @var
 	 */


 	/**
 	 *
 	 * a function wich initializes the language
 	 *
 	 * @param  
 	 *
 	 * @return
 	 */
 	public static function init()
 	{
 		$test = Decoder::yamlParseFile('../../src/test/Resources/views/languages/test.php');	
 	}
 }