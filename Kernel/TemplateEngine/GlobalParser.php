<?php

namespace Kernel\TemplateEngine;

class GlobalParser
{
	/**
	 * extract Strings between Chars to convert this in values from PHP
	 * 
	 * @param string $cFirstChar, $cSecondChar, $sString
	 *
	 * @return array
	 */
	private static function extractStringBetween($cFirstChar, $cSecondChar, $sString)
	{
	    preg_match_all("/\\".$cFirstChar."(.*?)\\".$cSecondChar."/", $sString, $aMatches);
	    return $aMatches;
	}

	/**
	 * returns the string between strings
	 * 
	 * @param string $start, $end, $string
	 *
	 * @return string
	 */
	protected static function getBetween($start = '', $end = '', $string)
	{
		$temp 	= strpos($string,$start)+strlen($start);
		$result = substr($string,$temp,strlen($string));
		$dd 	= strpos($result,$end);
		if($dd === 0){
			$dd = strlen($result);
		}
		return substr($result,0,$dd);
	}

	/**
	 * parse the strings between {{ }} 
	 * 
	 * @param string $sString
	 *
	 * @return array
	 */
	protected static function parseTemplateIssues($sString)
	{
		$cFirstChar = '{{';
		$cSecondChar = '}}';
	    return self::extractStringBetween($cFirstChar, $cSecondChar, $sString);
	}

	/**
	 * parse the strings between {% %} 
	 * 
	 * @param string $sString
	 *
	 * @return array
	 */
	protected static function parseTemplateFunctions($sString)
	{
		$cFirstChar = '{%';
		$cSecondChar = '%}';
	    return self::extractStringBetween($cFirstChar, $cSecondChar, $sString);
	}
}