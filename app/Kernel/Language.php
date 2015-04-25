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
	 * @var string
	 */
	private $srcFolder;

	/**
	 *
	 * The Constructor calls the setLanguage and the initLanguage
	 *
	 * @return void
	 */
	public function __construct($language = '', $srcFolder = '')
	{
		$this->language 	 = $this->setLanguage($language);
		$this->languageArray = $this->initLanguage($srcFolder);
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
			return substr($request->server['HTTP_ACCEPT_LANGUAGE'],0,2);
		}else{
			return $language;	
		}
	}

	/**
	 *
	 * The initLanguage Function returns the Translations as an array
	 *
	 * @param string $srcFolder
	 *
	 * @return array
	 */
	private function initLanguage($srcFolder)
 	{
 		return Decoder::yamlParseFile('src/'.$srcFolder.'/Resources/views/translations/message.'.$this->language.'.yml');	
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