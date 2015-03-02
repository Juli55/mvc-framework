<?php

namespace Kernel\LanguageEngine;

use Kernel\Decoder\Decoder;

/**
 * @author Dennis Eisele <dennis.eisele@online.de>
 */
 class LanguageEngine
 {
 	/**
 	 * @var array
 	 */
 	private $parsedLanguage;

 	/**
 	 *
 	 * a function wich initializes the language
 	 *
 	 * @param string $languagePack  
 	 *
 	 * @return void
 	 */
 	public function init($languagePack)
 	{
 		$parsedLanguage = Decoder::yamlParseFile('../../src/test/Resources/views/languages/' . $languagePack . '.yml');	
 	}

 	/**
 	 * @return array
 	 */
 	public function getLanguage()
 	{
 		return $parsedLanguage;
 	}
 }