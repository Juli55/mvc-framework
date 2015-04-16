<?php

namespace Kernel;

use Kernel\HttpKernel\Request;
use Kernel\Decoder\Decoder;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 * @author Dennis Eisele <dennis.eisele@online.de>
 */
class Language
{
	/**
	 * @var string
	 */
	private $language;

	/**
	 * @var array
	 */
	private $languageArray;

	/**
	 *
	 * The Constructor calls the setLanguage and the initLanguage
	 *
	 * @return void
	 */
	public function __construct($language = '')
	{
		$this->language 	 = $this->setLanguage($language);
		$this->languageArray = $this->initLanguage();
	}

	/**
	 *
	 * The setLanguage Function returns the browserLanguage or custom
	 *
	 * @param string $language
	 *
	 * @return string
	 */
	private function setLanguage($language)
	{
		if(empty($language)){
			$request = new Request();
			return $request->server['HTTP_ACCEPT_LANGUAGE'];
		}else{
			return $language;	
		}
	}

	private function initLanguage()
 	{
 		return Decoder::yamlParseFile('src/test/Resources/views/translations/message.' . LANGUAGE_DE . '.yml');	
 	}

	/**
	 *
	 * this Function returns the Language
	 *
	 * @return string
	 */
	public function getLanguage()
	{
		return $this->language;
	}

	/**
	 *
	 * this Function returns the parsed Language from the yml
	 *
	 * @return array
	 */
	public function getLanguageArray()
	{
		return $this->languageArray;
	}
}