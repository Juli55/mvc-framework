<?php

namespace Kernel\RoutingEngine;

use Kernel\Config;
use Kernel\View;
use Tools\Authentication\Security;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 * @author Dennis Eisele  <dennis.eisele@online.de>
 */
class RoutingEngine
{
	/**
	 * @var array
	 */
	private $parameters = array();

	/**
	 *
	 * The callController Function calls the Controller from the required srcFolder, if it exists
	 *
	 * @param string $dir
	 * @param array $config 
	 *
	 * @return dynamic
	 */
	public function callController($dir, $config)
	{
		//get the Controller and check if the user have the rights, if not it redirects to the Controller wich is set in the Configs
			$controllerFile = '../src/'.$dir.'/Controller/'.$config['controller'].'.php';
			$exist 			= file_exists($controllerFile);
			if($exist){
				require $controllerFile;
				$namespace  = str_replace("/","\\",$dir);
				$class      = $namespace.'\\Controller\\'.$config['controller'];
				$controller = new $class();
				//set security activity
					if(!isset($config['security'])){
						$security = true;
					}else{										
						$security = $config['security'];
					}
				if($security){
					$this->handleSecurity();	
				}
				return call_user_func_array(array($controller, $config['action']), $this->parameters);
			}else{
				//throw exception file doesn't exist
			}
	}

	/**
	 *
	 * The handleSecurity Function checks if the User is loggedIn and headers to the defined redirectTo
	 *
	 * @return boolean
	 */
	private function handleSecurity()
	{
		$securityObject = new Security;
		$loggedIn = $securityObject->login();
		if(!$loggedIn){
			//redirect to defined
				$securityConfig = Config::securityConfig();
				if($key !== $securityConfig['redirectTo']){
					$redirectAddress = trim(Config::routing()[$securityConfig['redirectTo']]['pattern'],'/');
					header('Location:/'.$redirectAddress);
				}else{
					//throw exceptions
				}
		}
		return true;
	}

	/**
	 *
	 * The handlePatternVariables Function checks the patternParts,
	 * if it is a Variable and saves it in the parameters objectProberty
	 *
	 * @param array $value
	 * @param string $uri
	 *
	 * @return void
	 */
	private function handlePatternVariables($value, $uri)
	{
		//set the pattern to check if a string is a patternVariable
			$cFirstChar 	 = '{';
			$cSecondChar 	 = '}';
			$patternVariable = "/\\".$cFirstChar."(.*?)\\".$cSecondChar."/";
		//remove the first and last '/' in pattern and uri
			$pattern = trim($value['pattern'], '/');
			$uri	 = trim($uri, '/');
		//explode pattern and uri by '/'
			$patternParts  = explode('/', $pattern);
			$uriParts	   = explode('/', $uri);
		//count the array to check if they have the same size
			$patternPartsCount = count($patternParts);
			$uriPartsCount 	   = count($uriParts);
		//handle the patternParts
			$parameters = $this->parameters;
			for($i = 0; $i < $patternPartsCount; $i++){
				//identify patternVariables an store in Pattern Array
					if($patternParts[$i] === $uriParts[$i]){	
					}elseif(preg_match($patternVariable,$patternParts[$i])){
						//identify the patternVariable
							preg_match($patternVariable,$patternParts[$i],$match); 
						//restore the patternVariable into the parameter Array
							$parameters[trim($match[1])] = preg_replace("#[?].*#", "", trim($uriParts[$i]));
							$this->parameters = $parameters;
					}else{
						//if the part of the uri was empty for this pattern
							break;
					}
			}		
	}

	/**
	 *
	 * The handleRouting function reads the routingPattern and handles the routingVariables, 
	 * checks if required that the User is logged in
	 *
	 * @param string $uri
	 *
	 * @return Controller, string
	 */
	public function handleRouting($uri)
	{
		$routing = Config::routing();
		$specialRouting = array('404');
		//check if uri fits in a routing pattern
			foreach($routing as $key => $value){
				if(!in_array($key, $specialRouting)){
					//check if the srcFolder from the Routing is initialized
						if(array_key_exists($value['srcFolder'], Config::SrcInit())){
							//check if the pattern equals the requested URI
								$srcFolder = Config::SrcInit()[$value['srcFolder']];
								$dir = ltrim($srcFolder, '/');
								if(is_dir('../src/'.$srcFolder)){
									if($value['pattern'] === $uri){
										return $this->callController($dir, $value);
									}else{
										//remove the first and last '/' in pattern and uri
											$pattern = trim($value['pattern'], '/');
											$uri	 = trim($uri, '/');
										//explode pattern and uri by '/'
											$patternParts  = explode('/', $pattern);
											$uriParts	   = explode('/', $uri);
										//count the array to check if they have the same size
											$patternPartsCount = count($patternParts);
											$uriPartsCount 	   = count($uriParts);
										//check if the patternParts equals the uriParts
											if($patternPartsCount === $uriPartsCount){
												//handle the patternParts
													for($i = 0; $i < $patternPartsCount; $i++){
														//identify patternVariables an store in Pattern Array
															$this->handlePatternVariables($value, $uri);
														//at the last continuous call the Controller
															if($i === $patternPartsCount-1){
																if($patternParts[0] === $uriParts[0]){
																	return $this->callController($dir, $value);	
																}
															}
													}

											}
									}
								}
						}
				}
			}
			if('/'.$uri === $_SERVER['PHP_SELF'] || $uri === ''){
				return "root";
			}else{
				if(isset($routing['404'])){
					if(isset($routing['404']['template'])){
						$file = $routing['404']['template'];
						$exist = file_exists($file);
						if($exist){
							ob_start();
							include $file;
							$output = ob_get_contents();
							ob_end_clean();
							return $output;
						}else{
							//throw Exception
								return $file.' not found';
						}
					}else{
						$srcFolder = Config::SrcInit()[$routing['404']['srcFolder']];
						$dir = ltrim($srcFolder, '/');
						if(is_dir('../src/'.$srcFolder)){
							$dir = ltrim($srcFolder, '/');
							return $this->callController($dir, $routing['404']);
						}
					}
				}
				return "Page not found!";
			}
	}
}