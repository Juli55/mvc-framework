<?php
use Kernel\Controller;
use Config\Routing;

function __autoload($class_name) {
    include $class_name . '.php';
}
if(isset($_GET['url']))
{
	//echo $_GET['url'];
	$dir = explode('/',$_GET['url']);
}

echo Controller::test();

Routing::init();
	foreach(Routing::getRouting() as $key => $value){
		//echo $value['pattern'];
		//echo "<br />";
		//echo $_GET['url'];
		$hey = preg_match("/\\".'$'."/", $value['pattern']);
		$hey_array = preg_match_all("/\\".'$'."/", $_GET['url'], $aMatches);
		print_r($aMatches);
		if($hey){

			//echo 'hey';
		}
		if($value['pattern'] === $_GET['url']){
			return true;
		}
	}