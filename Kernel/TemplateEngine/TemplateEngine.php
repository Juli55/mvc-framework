<?php

namespace Kernel\TemplateEngine;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class TemplateEngine
{
	/**
	 * @var string
	 */
	protected static $output;


	/**
	 * extract Strings between Chars to convert this in values from PHP
	 * 
	 * @param string $cFirstChar, $cSecondChar, $sString
	 *
	 * @return array
	 */
	protected static function extractStringBetween($cFirstChar, $cSecondChar, $sString)
	{
	    preg_match_all("/\\".$cFirstChar."(.*?)\\".$cSecondChar."/", $sString, $aMatches);
	    return $aMatches;
	}

	/**
	 * transformate the values between "{{ }}" and take the content to replace them with the PHP variable/array
	 * 
	 * @param string $output
	 * @param array $parameters
	 * 
	 * @return void
	 */
	protected static function valueTransformation($output, $parameters)
	{
		$template_variable = self::extractStringBetween('{{','}}',$output);
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
			}

			else{

				$replace = $parameters[trim($value)];	
			}

			$pattern = '/{{'.$value.'}}/';
			if(is_string($replace)){
				$output = preg_replace($pattern,$replace,$output);
			}
			else{
				$output = preg_replace($pattern,$value,$output);
			}
		}

		self::$output = $output;
	}

	/**
	 * returns the transformated output from template 
	 *
	 * @return string
	 */
	protected static function getOutput()
	{
		return self::$output;
	}
}