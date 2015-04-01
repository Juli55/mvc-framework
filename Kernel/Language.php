<?php

namespace Kernel;

use Kernel\HttpKernel\Request;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class Language
{
	/**
	 * @var string
	 */
	private $language;

	/**
	 *
	 * The Constructor calls the setLanguage
	 *
	 * @return void
	 */
	public function __construct($language = '')
	{
		$this->language = $this->setLanguage($language);
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
}