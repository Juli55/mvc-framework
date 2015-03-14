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
 	public function initLanguage($languagePack)
 	{
 		Decoder::yamlParseFile(ROOT_PATH . 'src/test/Resources/views/translation/' . $languagePack . LANGUAGE_DE . '.yml');	
 	}

 	/**
 	 * @return array
 	 */
 	public function getLanguage()
 	{
 		return $parsedLanguage;
 	}
 }