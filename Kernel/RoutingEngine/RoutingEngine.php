<?php

namespace Kernel\RoutingEngine;

use Config\Routing;

class RoutingEngine
{

	/**
	 * @return Controller
	 */
	public static function handleRouting($uri)
	{
		//initalize the routings
		Routing::init();

		//check if uri fits in a routing pattern
		foreach(Routing::getRouting() as $key => $value){

			$dir = ltrim($value['dir'], '/');

			if($value['pattern'] === $uri){

				require '../src/'.$dir.$value['controller'].'.php';
				$namespace = str_replace("/","\\",$value['dir']);
				$class = $namespace.$value['controller'];
				$controller = new $class();
				
				return call_user_func($controller, $value['action']);

			}else{

				//set the pattern to check if a string is a patternVariable
				$cFirstChar 	 = '{';
				$cSecondChar 	 = '}';
				$patternVariable = "/\\".$cFirstChar."(.*?)\\".$cSecondChar."/";

				//remove the first and last '/' in pattern and uri
				$pattern = trim($value['pattern'], '/');
				$uri	 = trim($uri, '/');

				//explode pattern and uri by '/'
				$pattern_parts = explode('/', $pattern);
				$uri_parts	   = explode('/', $uri);

				//count the array to check if they have the same size
				$pattern_parts_count = count($pattern_parts);
				$uri_parts_count 	 = count($uri_parts);

				if($pattern_parts_count === $uri_parts_count){

					$parameters = array();

					for($i = 0; $i < $pattern_parts_count;$i++){

						if($pattern_parts[$i] === $uri_parts[$i]){

						 //check if the part is a variable	
						}elseif(preg_match($patternVariable,$pattern_parts[$i])){

							preg_match($patternVariable,$pattern_parts[$i],$match); 

							//restore the patternvariable into the parameter_array
							$parameters[trim($match[1])] = preg_replace("#[?].*#", "", trim($uri_parts[$i]));

						}else{

							//if the part of the uri was empty for this pattern
							break;
						}
						if($i === $pattern_parts_count-1){

							$controllerFile = '../src/'.$dir.$value['controller'].'.php';
							$exist = file_exists($controllerFile);
							if($exist){
								require '../src/'.$dir.$value['controller'].'.php';
								$namespace = str_replace("/","\\",$value['dir']);
								$class = $namespace.$value['controller'];
								$controller = new $class();

								return call_user_func_array(array($controller, $value['action']), $parameters);

							}else{

								return 'Controller: "'.$value['controller'].'" existiert nicht in: "'.$dir.'"!';

							}	
						}
					}

				}
			}

		}

	}
}