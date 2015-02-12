<?php	

namespace Kernel\TemplateEngine;

use Kernel\TemplateEngine\GlobalParser;
use Kernel\RoutingEngine\RoutingEngine;
use Kernel\View;

class TemplateParser extends GlobalParser
{

	/**
	 * @var array
	 */
	private $parameters;

	/**
	 * @var string
	 */
	private $output;

	/**
	 * @return void 
	 */
	public function __construct($output,$parameters)
	{
		$new_output = $this->parsingTemplateFunctions($output,$parameters);

		$this->output = $this->parseTemplateEngine($new_output,$this->parameters);
	}

	/**
	 * parse functions from template
	 * 
	 * @param array $parameters
	 * 
	 * @return void
	 */
	private function parsingTemplateFunctions($output,$parameters)
	{
		$this->parameters = $parameters;
		$template_issues = self::parseTemplateFunctions($output);
		foreach($template_issues[1] as $key => $value){

		// set Template Variables
			$substr = explode(' ', trim($value));
			if($substr[0] == 'set'){

				$variable_setter = ltrim(trim($value), 'set');

				$KeyValue = explode('=',$variable_setter);
				$VariableKey = trim($KeyValue[0]);
				$VariableValue = trim($KeyValue[1]);

				if (ctype_digit($value)) {
					$this->parameters[$VariableKey] = $VariableValue;
				}
				elseif((preg_match("/\\".'"'."(.*?)\\".'"'."/",$VariableValue))||preg_match("/\\".'\''."(.*?)\\".'\''."/",$VariableValue)){
					
					$variable = trim($VariableValue, '\'');
					$variable = trim($VariableValue, '"');
					$this->parameters[$VariableKey] = $variable;

				}elseif(array_key_exists($VariableValue,$parameters)){

					$this->parameters[$VariableKey] = $parameters[$VariableValue];
					print_r($this->parameters);
				}elseif(strpos($VariableValue,'.')){
					$array = explode('.',$VariableValue);

					$array_storage = $parameters;
					foreach($array as $key2 => $value2){
						if(array_key_exists(trim($value2), $array_storage)) {
							$array_storage =  $array_storage[trim($value2)];
						}
					}
					$this->parameters[$VariableKey] = $array_storage;

				}
			}elseif($substr[0] == 'import') {

				$pattern = '/{%'.$value.'%}/';
				$routingEngine = new RoutingEngine;
				$replace = $routingEngine->handleRouting($substr[1]);
				$output = preg_replace($pattern,$replace,$output);
			}elseif($substr[0] == 'include') {

				$pattern = '/{%'.$value.'%}/';
				$replace =  View::render($substr[1], $parameters);
				$output = preg_replace($pattern,$replace,$output);
			}elseif($substr[0] == 'for') {
						
				$endString = self::parseTemplateFunctions($output);
				foreach($endString[1] as $keyFor => $valueFor){
					$substr2 = explode(' ', trim($valueFor));
					if($substr2[0] == 'endfor'){
						$end = '{%'.$valueFor.'%}';
					}
				}
				$start = '{%'.$value.'%}';
				$forContent = self::GetBetween($start, $end, $output);
				$result = '';
				foreach($parameters[$substr[1]] as $key2 => $value2){

					$parameters[$substr[3]] = $parameters[$substr[1]][$key2]; 
					$result .=  self::parseTemplateEngine($forContent,$parameters);
					
				}
				$pattern = '('.$start.$forContent.$end.')i';
				$output = preg_replace($pattern,$result,$output);
	    		
			}
			$pattern = '/{%'.$value.'%}/';
			$output = preg_replace($pattern,'',$output);
		}

		
		return $output;
	}

	/**
	 * parse issues from template
	 * 
	 * @param string $output
	 * @param array $parameters
	 * 
	 * @return string
	 */
	private function parseTemplateEngine($output,$parameters)
	{
		//read TemplateVariables
		$template_variable = self::parseTemplateIssues($output);
		$pattern = array();
	    foreach($template_variable[1] as $key => $value){

			if(strpos($value,'.')){

				$array = explode('.',$value);
				
				$array_storage = $parameters;
				foreach($array as $key2 => $value2){
					
					if(is_object($array_storage)){
						
						$methodName = 'get'.ucfirst(trim($value2));
						$array_storage = $array_storage->$methodName();

					}elseif(array_key_exists(trim($value2), $array_storage)) {

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
					elseif(is_object($replace)){

					}else{
						$output = preg_replace($pattern,$value,$output);
					}
				}
			}
		}

		return $output;
	}

	/**
	 * @return string
	 */
	public function getOutput()
	{
		return $this->output;
	}
}