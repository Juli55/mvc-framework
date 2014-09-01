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

						echo $aMatches[0][0];
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