<?php
use Kernel\Controller;
use Config\Routing;
use profile\Controller\profileController;

function __autoload($class_name) {
    include $class_name . '.php';
}
/*
if(isset($_GET['url']))
{
	//echo $_GET['url'];
	$dir = explode('/',$_GET['url']);
}
*/

Routing::init();


	foreach(Routing::getRouting() as $key => $value){
		
		if($value['pattern'] === $_GET['url']){

			require $value['dir'].$value['controller'].'.php';
			$namespace = str_replace("/","\\",$value['dir']);
			$class = $namespace.$value['controller'];
			$controller = new $class();

			echo $controller->test();

		}
		/*
		$hey = preg_match("/\\".'$'."/", $value['pattern']);
		$hey_array = preg_match_all("/\\".'$'."/", $_GET['url'], $aMatches);
		print_r($aMatches);
		if($hey){

			//echo 'hey';
		}
		if($value['pattern'] === $_GET['url']){
			return true;
		}
		*/
	}