<?php

namespace Kernel\Decoder;

use Kernel\Decoder\Yaml\Yaml; 

/**
 * @author Dennis Eisele  <dennis.eisele@online.de>
 * @author Julian Bertsch <Julian.bertsch42@gmail.com>
 */
class Decoder
{
	/**
	 *
	 * the function returns a parsed array of a yaml file
	 *
	 * @param String $fileName
	 *
	 * @return array
	 */
	public static function yamlParseFile($fileName)
	{
		//setting rootPath
			$upperFolders = 2;
			$scriptName   = basename(__FILE__);
			$rootPath 	  = str_replace($scriptName,'',__FILE__);
			for($i = 0;$i < $upperFolders;$i++){
				$folderName = basename($rootPath);
				$rootPath   = str_replace($folderName.DIRECTORY_SEPARATOR,'',$rootPath);	 
			}
		//checking rootpath
			if(file_exists($rootPath.$fileName)){
				//returning parsed yaml file
					return Yaml::parse($rootPath.$fileName);
			}elseif(file_exists(__DIR__.'/../'.$fileName)){
				//returning parsed yaml file
					return Yaml::parse(__DIR__.'/../'.$fileName);
			}else{
				//throw Exception
					die("File doesn't exist or Rootpath is wrong");
		}
	}
	
	/**
	 *
	 * this function is to get the keys and values from an proberty
	 *
	 * @param object $object
	 * @param array $patternArray
	 *
	 * @return array
	 */
	public static function getAnnotationProbertys($object, $patternArray)
	{
		//init probertyCollection
			$probertyCollection = array();
		//get reflacted Class
			$reflectionClass = new \ReflectionClass($object);
		//generate an array of the Annotationprobertys
			$reflectedProperty 		= $reflectionClass->getProperty($key);
			$propertyDocumentation  = $reflectedProperty->getDocComment();
		//get an String Array of lines with the probertyAnnotations
			$probertyAllType = array();
			foreach($patternArray as $pattern){
				preg_match_all('/@'.$pattern.'\(.*\)/', $propertyDocumentation, $probertyOneType);
				$probertyAllType = array_merge($probertyAllType, $probertyOneType);
			}
		//set an array for the probertys and set standarts
			$probertys = array('type' => 'varchar');
		//foreach the AnnotationprobertyArray to get the Probertys
			foreach($probertyAllType[0] as $probAnnotation){
				//remove the patternSyntax to get the key and value
					foreach($patternArray as $pattern){
						$prob = ltrim($probAnnotation,'@'.$pattern);
					}
					//get key and value
						$prob 	= ltrim($prob,'(');
						$prob 	= rtrim($prob,')');
						$prob 	= explode('=',$prob);
						$akey   = trim(trim($prob[0]),"'");
						$avalue = $prob[1];
				//add probertys to the Array
					$probertys[$akey] 	  = $avalue;
					$probertyCollection[] = $probertys;
			}
		return $probertyCollection;
	}
}