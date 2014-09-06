<?php

use Kernel\Controller;
use Config\Routing;
use profile\Controller\profileController;

	function __autoload($class_name)
	{
	    include '../'.$class_name . '.php';
	}

	final class App
	{

		/**
		 * @var string
		 */
		private static $uri;

		function __construct()
		{

			if(isset($_SERVER['PATH_INFO'])){

				self::$uri = $_SERVER['PATH_INFO'];
				
			}
			elseif($_SERVER['SCRIPT_NAME'] === $_SERVER['PHP_SELF']){
				self::$uri = $_SERVER['REQUEST_URI'];
			}
			else{

				self::$uri = $_SERVER['REQUEST_URI'];
			}

			self::routing();
		}

		private static function routing()
		{
			
			if(self::$uri !== $_SERVER['PHP_SELF'] && self::$uri !== '/')
			{
				echo Routing::handleRouting(self::$uri);
			}
			else
			{
				echo 'root';
			}
		}
		
	}
	new App();