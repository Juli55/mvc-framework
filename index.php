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
				echo Routing::handleRouting($_GET['url']);
			}
			else
			{
				echo "root";
			}
		}
		
	}
	new App();