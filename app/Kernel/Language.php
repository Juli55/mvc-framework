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
	 * The initLanguage function returns the translations as an array
	 *
	 * @param string $srcFolder
	 *
	 * @return array
	 */
	private function initLanguage($srcFolder)
 	{
 		//checks if default exists in the LanguagesInit
 			if(array_key_exists("default",Decoder::yamlParseFile('Config/LanguagesInit.yml'))){
 				//read default language
 					$defaultLanguage = Decoder::yamlParseFile('Config/LanguagesInit.yml')['default'];
 			}else{
 				//throw Exception
 					die("Key 'default' doesn't exist");
 			}
 		//checks if language file 
 			if(self::languageExists($this->language,$srcFolder)){
 				//getting content of language file 
 					$languageArray = Decoder::yamlParseFile('src/'.$srcFolder.'/Resources/translations/message.'.$this->language.'.yml');
 			}elseif(!empty($defaultLanguage) && self::languageExists($defaultLanguage,$srcFolder)){
 				//getting content of default language file
 					$languageArray = Decoder::yamlParseFile('src/'.$srcFolder.'/Resources/translations/message.'.$defaultLanguage.'.yml');
 			}else{
 				//throw Exception
 					die("The default language file doesn't exist or the default language isn't set");
 			}
 		return $languageArray;
 	}

 	/**
	 *
	 * The languageExists function checks if a Language is available or not
	 *
	 * @param string $language
	 *
	 * @return boolean
	 */
 	private function languageExists($language)
 	{
 		if(array_key_exists("languages",Decoder::yamlParseFile('Config/LanguagesInit.yml'))){
 			//get all languages
 				$languages = Decoder::yamlParseFile('Config/LanguagesInit.yml')['languages'];
 			//check if language is available
 				if(in_array($language,$languages)){
 					return true;
 				}else{
 					return false;
 				}
 		}else{
 			//throw Exception 
 				die("Key 'languages' doesn't exist");
 		}
 	}

 	/**
	 *
	 * The translateFunction returns the the translation of a string
	 *
	 * @param string $subject
	 *
	 * @return string
	 */
	public function translate($subject)
	{
		//get translation
			$array = explode('.',$subject);
			$arrayStorage = $this->getLanguageArray();
			foreach ($array as $key => $value){
				if(array_key_exists(trim($value), $arrayStorage)){
					$arrayStorage =  $arrayStorage[trim($value)];
				}else{
					//throw Exception
						die("The Index doesn't exist");
				}
			}
			$translation = $arrayStorage;
		//checking translation
			if(!is_array($translation)){
				return $translation;
			}elseif(is_array($translation)){
				//throw Exception
					die("The translation can't be an array");
			}else{
				//throw Exception
					die("Something went wrong while translating");
			}
		
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