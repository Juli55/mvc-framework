<?php

use Kernel\Controller;
use Config\Routing;
use profile\Controller\profileController;

	function __autoload($class_name)
	{
	    include $class_name . '.php';
	}

	final class App
	{
		function __construct()
		{
			self::routing();
		}

		private static function routing()
		{
			if(isset($_GET['url']))
			{
				//echo $_GET['url'];
				$dir = explode('/',$_GET['url']);

				Routing::init();


				foreach(Routing::getRouting() as $key => $value){
					
					if($value['pattern'] === $_GET['url']){

						require $value['dir'].$value['controller'].'.php';
						$namespace = str_replace("/","\\",$value['dir']);
						$class = $namespace.$value['controller'];
						$controller = new $class();

						echo $controller->$value['action']();

					}
					else{

						$cFirstChar = '{';
						$cSecondChar = '}';
						preg_match_all("/\\".$cFirstChar."(.*?)\\".$cSecondChar."/", $value['pattern'], $aMatches);
						//$output = preg_replace("/\\".$cFirstChar."(.*?)\\".$cSecondChar."/",'',$value['pattern']);
						$output1 = array_reverse($aMatches[0]);
						$output2 = $value['pattern'];
						foreach ($output1 as $key => $value) {
							$output2 =  rtrim($output2,$value);
							// echo "<br />";
							$output2 =  rtrim($output2,'/');
							//echo "<br />";
							
							//echo rtrim($_GET['url'],$uri[0]);
						}
						$uri = explode('/',$_GET['url']);
						//echo $uri[1];

						$output_uri = $_GET['url'];
						$variable_count =  count($output1);
						$i = 0;
						foreach($uri as $key => $value){
							if($i <= $variable_count){
								$output_uri =  rtrim($output_uri,$value);

								$output_uri =  rtrim($output_uri,'/');
								$i++;
							}
							else{
								break;
							}
						}
						echo $output_uri;
						 
						 $output2;
					}
				}
			}
			else
			{
				echo "root";
			}
		}
		
	}
	new App();