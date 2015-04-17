<?php

namespace Kernel\TemplateEngine;

use Kernel\RoutingEngine\RoutingEngine;
use Kernel\View;
use Kernel\Language;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 * @author Dennis Eisele <dennis.eisele@online.de>
 */
class TemplateParser extends GlobalParser
{
	/**
	 * @var array
	 */
	public static $parameters = array();

	/**
	 * @var string
	 */
	private $output;

	/**
	 * @var blocks
	 */
	public static $blocks = array();

	/**
	 *
	 * The constructor parses the Output an put it in the objectProberty $output 
	 *
	 * @param string $output
	 * @param array $parameters
	 *
	 * @return void 
	 */
	public function __construct($output, $parameters = array(), $blocks = array())
	{
		$this->output 			 = $output;
		self::$parameters 		 = array_merge($parameters, self::$parameters);
		self::$blocks 		 	 = array_merge($blocks, self::$blocks);
		$this->parsingTemplateFunctions();
		$this->output = $this->parseTemplateParameters($this->output, self::$parameters);
	}

	/**
	 *
	 * The parsingTemplateFunctions parse functions from template, change parameters and store them
	 * 
	 * @return void
	 */
	protected function parsingTemplateFunctions()
	{
		$output 	  	= $this->output;
		$parameters 	= self::$parameters;
		$templateIssues = self::parseTemplateFunctions($output);
		foreach($templateIssues[1] as $key => $value){
			//replace the templateFunctionsSyntax in the values
				$subStrings = explode(' ', trim($value));
				if($subStrings[0] === 'set'){
					$parameters = $this->setTemplateVariables($value, $parameters);
				}elseif($subStrings[0] === 'import'){
					$output = $this->importController($value, $output);
				}elseif($subStrings[0] == 'include'){
					$output = $this->includeTemplate($value);
				}elseif($subStrings[0] == 'for'){
		    		$output = $this->forLoop($value, $subStrings, $parameters, $output);
				}elseif($subStrings[0] == 'block'){
					self::$blocks = $this->defineBlock($output, $value, $subStrings, self::$blocks);
				}elseif($subStrings[0] == 'use'){
					$this->useTemplate($subStrings, $parameters, self::$blocks);
				}
				//replace command with value
					$pattern = '/{%'.$value.'%}/';
					$output  = preg_replace($pattern,'',$output);
		}
		self::$parameters = $parameters;
		$this->output 	  = $output;
	}

	/**
	 *
	 * The parseTemplateParametersMethod parse issues from template
	 * 
	 * @param string $output
	 * @param array $parameters
	 * 
	 * @return string
	 */
	protected function parseTemplateParameters($output, $parameters)
	{
		//read TemplateVariables
			$template_variable = self::parseTemplateIssues($output);
			$replace = '';
			$pattern = array();
		    foreach($template_variable[1] as $key => $value){
		    	$subStrings = explode(' ', trim($value));
		    	if(strpos($value,'trans'))
		    	{
		    		$output = $this->readLanguages($value,$output);
		    	}
		    	else{
		    	//if the Value is split by '.' it want to call an Array or Object, else it reads the Parameter by the first Key
					if(strpos($value,'.')){
						$output = $this->readObjectsAndArrays($value, $parameters, $output);
					}else{
						$subStrings = explode(' ', trim($value));
						if($subStrings[0] === 'block'){
							$output = $this->callBlock($value, $subStrings, self::$blocks, $output);
						}else{
							$output = $this->readParameter($value, $parameters, $output);
						}
					}
				}
			}
		return $output;
	}

	/**
	 * 
	 * The readObjectsAndArraysMethod parse templateArrays or Objects and replace them in output with the value
	 *
	 * @param string $value, $output
	 * @param array $parameters
	 *
	 * @return string
	 */
	private function readObjectsAndArrays($value, $parameters, $output)
	{
		//explode Value with '.', foreach it and check if it is in the parameters and if it is an Object or an Array and store the Data
			$array = explode('.',$value);				
			$arrayStorage = $parameters;
			foreach($array as $key2 => $value2){
				//if is object then call with the second Key the getMethod from the Object, else if it is an array then store the while the value is an array and then store the stringValue to replace						
					if(is_object($arrayStorage)){						
						$methodName = 'get'.ucfirst(trim($value2));
						if(method_exists($arrayStorage,$methodName)){
							$arrayStorage = $arrayStorage->$methodName();
						}else{
							//throw Exception
								die("das Objekt enth&auml;lt diese Methode nicht");
						}
					}elseif(is_array($arrayStorage)){
						if(array_key_exists(trim($value2), $arrayStorage)){
							$arrayStorage =  $arrayStorage[trim($value2)];
						}else{
							//throw Exception
								die("der Index existiert nicht");
						}
					}else{
						//throw Exception
							die("ein string kann keinen index besitzen");
					}
			}
			$replace = $arrayStorage;
		//replace the Commands with the Value
			$pattern = '/{{'.$value.'}}/';
			if(is_string($replace) || is_int($replace)){
				$output = preg_replace($pattern,$replace,$output);
			}
			else{
				$output = preg_replace($pattern,$value,$output);
			}
		return $output;
	}

	/**
	 * 
	 * The readLanguagesMethod parses the language in template and replace them in output with the value
	 *
	 * @param string $value, $output
	 * @return string
	 */
	private function readLanguages($value, $output)
	{
		$Language = new Language;
		$value = self::getBetween("'","'",$value);
		$array = explode('.',$value);
		$arrayStorage = $Language->getLanguageArray();
		foreach ($array as $key2 => $value2) {
			if(array_key_exists(trim($value2), $arrayStorage)){
				$arrayStorage = $arrayStorage[trim($value2)];
			}else{
				die("der Index existiert nicht");
				//throw Exception
			} 	
		}
		$replace = $arrayStorage;
		$pattern = '/{{'."'".$value."'".'\|trans'.'}}/';
		$output = preg_replace($pattern,$replace,$output);
		return $output;
	}

	/**
	 * 
	 * this method calls the Block and replace the Content wih callSyntax
	 * 
	 * @param string $value, $output
	 * @param array $parameters
	 *
	 * @return string
	 */
	private function callBlock($value, $subStrings, $blocks, $output)
	{
		$pattern = '/{{'.$value.'}}/';
		if(isset($subStrings[1])){
			if(isset($blocks[$subStrings[1]])){
				$blockContent = $blocks[$subStrings[1]];
				$replace = str_replace("'","\\\'",$blockContent);
				$replace = str_replace("\"","\\\"",$replace);
				$replace = preg_replace("#[\r|\n]#", '', $replace);
				$replace = trim($replace);
				$output  = preg_replace($pattern,$replace,$output);
			}else{
				//throw Exceptions
					die('the called block is undefined');
			}
		}else{
			//throw Exceptions
				die('the block which should call is undefined');
		}
		return $output;
	}

	/**
	 * 
	 * The readParameterMethod reads the Value of the Parameter with the templateVariable as Key and replace it with the Value 
	 * 
	 * @param string $value, $output
	 * @param array $parameters
	 *
	 * @return string
	 */
	private function readParameter($value, $parameters, $output)
	{
		//check if the arrayKey exists and replace the callSyntax with the value
			if(isset($parameters[trim($value)])){			
				$replace = $parameters[trim($value)];
				$pattern = '/{{'.$value.'}}/';
				if(is_string($replace)){
					$output = preg_replace($pattern,$replace,$output);
				}elseif(is_object($replace)){
					//throw Exception
						die("object to string convertation");
				}else{
					$output = preg_replace($pattern,$value,$output);
				}
			}
		return $output;
	}

	/**
	 *
	 * The setTemplateVariablesMethod add an field in the array with the key and value from templateVariableSetter
	 *
	 * @param string $subString
	 * @param array $parameters
	 *
	 * @return array
	 */
	private function setTemplateVariables($subString, $parameters)
	{
		//get the Key and Value from setted Variable
			$variableSetter = ltrim(trim($subString), 'set');
			$KeyValue 		= explode('=',$variableSetter);
			$variableKey 	= trim($KeyValue[0]);
			$variableValue 	= trim($KeyValue[1]);
		//classify the valueType
			if(ctype_digit($subString)){
				$parameters[$variableKey] = $variableValue;
			}elseif((preg_match("/\\".'"'."(.*?)\\".'"'."/",$variableValue))||preg_match("/\\".'\''."(.*?)\\".'\''."/",$variableValue)){
				//if the variable has double quotes, then it is a string variable and the double quotes will trimmed
					$variable = trim($variableValue, '\'');
					$variable = trim($variableValue, '"');
					$parameters[$variableKey] = $variable;
			}elseif(array_key_exists($variableValue,$parameters)){
				//if a key already exist rewrite the Value
					$parameters[$variableKey] = $parameters[$variableValue];
			}elseif(strpos($variableValue,'.')){
				//if the subString has '.' then it want to call a multidimensional Array
					$array = explode('.',$variableValue);
					$arrayStorage = $parameters;
					foreach($array as $key => $value){
						if(array_key_exists(trim($value), $arrayStorage)) {
							$arrayStorage =  $arrayStorage[trim($value)];
						}
					}
					$parameters[$variableKey] = $arrayStorage;
			}
		return $parameters;
	}

	/**
	 * 
	 * The importControllerMethod imports an Controller through the Routing
	 *
	 * @param string $subString, $output
	 * 
	 * @return string
	 */
	private function importController($subString, $output)
	{
		//call  the handleRoutingMethod from RoutingEngine to get the Value
			$routingEngine = new RoutingEngine;
			$replace = $routingEngine->handleRouting($subString[1]);
		//replace the templateCall with the Value
			$pattern = '/{%'.$subString.'%}/';
			$output =  preg_replace($pattern,$replace,$output);
		return $output;
	}

	/**
	 *
	 * The includeTemplateMethod includes only the Template wich is parsed through the renderMethod from View
	 *
	 * @param string $value, $output
	 * @param array $parameters
	 *
	 * @return string
	 */
	private function includeTemplate($value, $parameters, $output)
	{
		//call the renderMethod from View
			$View = new View();			
			$replace =  $View->render($subString[1], $parameters, $blocks);
		//replace the templateCall with the Value
			$pattern = '/{%'.$value.'%}/';
			$output =  preg_replace($pattern,$replace,$output);
		return $output;
	}

	/**
	 *
	 * The forLoop function parses the templateForEachFunction 
	 *
	 * @param string $subString, $output
	 * @param array $subStrings, $parameters
	 *
	 * @return string
	 */
	private function forLoop($subString, $subStrings, $parameters, $output)
	{
		//get the endString from the forLoop
			$endString = self::parseTemplateFunctions($output);
			foreach($endString[1] as $keyFor => $valueFor){
				$subString2 = explode(' ', trim($valueFor));
				if($subString2[0] == 'endfor'){
					$end = '{%'.$valueFor.'%}';
					break;
				}
			}
		//get the value of the finish for
			$start = '{%'.$subString.'%}';
			$forContent = self::getBetween($start, $end, $output);
			$result = '';
			if(isset($parameters[$subStrings[1]])){
				if(is_array($parameters[$subStrings[1]]) || is_object($parameters[$subStrings[1]])){
					foreach($parameters[$subStrings[1]] as $key => $value){
						$parameters[$subStrings[3]] = $parameters[$subStrings[1]][$key]; 
						$result .=  $this->parseTemplateParameters($forContent, $parameters);				
					}
				}else{
					//throw exception
						die("der Index ist kein Array oder Objekt");
				}
			}else{
				//throw exception
					die("der Index ist undefiniert");
			}
			$pattern = '('.$start.$forContent.$end.')i';
		$output = preg_replace($pattern,$result,$output);
		return $output;
	}

	/**
	 *
	 * The defineBlock function gets the value of an Block and add it to array from parameter then returns it 
	 *
	 * @param string $subString, $output
	 * @param array $subStrings, $blocks
	 *
	 * @return array
	 */
	private function defineBlock($output, $subString, $subStrings, $blocks)
	{
		//extract blockValue
			//get the endString from the forLoop
				$endString = self::parseTemplateFunctions($output);
				foreach($endString[1] as $keyBlock => $valueBlock){
					$subString2 = explode(' ', trim($valueBlock));
					if($subString2[0] == 'endblock' && $subString2[1] == $subStrings[1]){
						$end = '{%'.$valueBlock.'%}';
						break;
					}
				}
		//get the value of the finish for
			$start 		  			= '{%'.$subString.'%}';
			$blockContent 			= self::getBetween($start, $end, $output);
			$View = new View();
			$renderedBlockContent = $View->render('', self::$parameters, $blocks, $blockContent);
			$blocks[$subStrings[1]] = $renderedBlockContent;
		return $blocks;
	}

	/**
	 *
	 * The useBlock Function takes an templateCall and returns the added blocks of it
	 *
	 * @param array $subStrings, $parameters, $blocks
	 *
	 * @return void
	 */
	private function useTemplate($subStrings, $parameters, $blocks)
	{
		//render File
			$View = new View();
			$renderedFile = $View->render($subStrings[1], $parameters, $blocks);
		//add blocks to global array
			$templateIssues = self::parseTemplateFunctions($renderedFile);
	}

	/**
	 * @return string
	 */
	public function getOutput()
	{
		return $this->output;
	}
}