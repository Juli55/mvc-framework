<?php	

namespace Kernel\TemplateEngine;

use Kernel\TemplateEngine\GlobalParser;
use Kernel\TemplateEngine\TemplateEngine;

class TempateParser extends GlobalParser
{

	/**
	 * @var string
	 */
	private static $output;

	/**
	 * @var array
	 */
	private static $parameters;

	public function __construct()
	{
		self::$output 	  = TemplateEngine::$output;
		self::$parameters = TemplateEngine::$parameters;

		self::init();
	}

	private static function init()
	{
		self::setVariable();
		self::readVariable();
	}

	/**
	 * parse functions from template
	 * 
	 * @param array $parameters
	 * 
	 * @return void
	 */
	private static function parsingTemplateFunctions()
	{
		$output = self::$output;
		$parameters = self::$parameters;

		$template_set_variable = self::parseTemplateFunctions($output);
		foreach($template_set_variable[1] as $key => $value){

			$pattern = '/{%'.$value.'%}/';
			$output = preg_replace($pattern,'',$output);
			self::$output = $output;

			$substr = explode(' ', trim($value));
			if($substr[0] == 'set'){
				$value2 = ltrim(trim($value), 'set');
				//echo $value2;

				$substr2 = explode('=',$value2);
				$key = trim($substr2[0]);
				$value = trim($substr2[1]);
				$array = explode('.',$value);

				if (ctype_digit($value)) {
					self::$parameters[trim($substr2[0])] = $value;
					print_r(self::$parameters);
				}
				elseif((preg_match("/\\".'"'."(.*?)\\".'"'."/",$value))||preg_match("/\\".'\''."(.*?)\\".'\''."/",$value)){

					self::$parameters[trim($substr2[0])] = trim($value, '\'');
					self::$parameters[trim($substr2[0])] = trim($value, '"');

				}
				elseif(array_key_exists($value,self::$parameters)){
						
					self::$parameters[trim($substr2[0])] = self::$parameters[$value];
				}
				elseif(strpos($value,'.')){
					$array = explode('.',$value);

					$array_storage = self::$parameters;
					foreach($array as $key2 => $value2){
						if(array_key_exists(trim($value2), $array_storage)) {
							$array_storage =  $array_storage[trim($value2)];
						}
					}
					self::$parameters[trim($substr2[0])] = $array_storage;

				}
			}
		}
	}

	/**
	 * parse issues from template
	 * 
	 * @param string $output
	 * @param array $parameters
	 * 
	 * @return void
	 */
	private static function parseTemplateEngine()
	{
		$output = self::$output;
		$parameters = self::$parameters;

		$template_variable = self::parseTemplateIssues($output);
		$replace = '';
		$pattern = array();
	    foreach($template_variable[1] as $key => $value){

			if(strpos($value,'.')){

				$array = explode('.',$value);

				$array_storage = $parameters;
				foreach($array as $key2 => $value2){
					if(array_key_exists(trim($value2), $array_storage)) {
						$array_storage =  $array_storage[trim($value2)];

					}
				}
				$replace = $array_storage;

				$pattern = '/{{'.$value.'}}/';
				if(is_string($replace)){
					$output = preg_replace($pattern,$replace,$output);
				}
				else{
					$output = preg_replace($pattern,$value,$output);
				}
			}else{
				
				if(isset($parameters[trim($value)])){
					$replace = $parameters[trim($value)];

					$pattern = '/{{'.$value.'}}/';
					if(is_string($replace)){
						$output = preg_replace($pattern,$replace,$output);
					}
					else{
						$output = preg_replace($pattern,$value,$output);
					}
				}
			}
		}

		self::$output  = $output;
	}

	public function getOutput()
	{
		return self::$output;
	}
}