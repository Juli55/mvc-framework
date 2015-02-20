<?php

use Kernel\RoutingEngine\RoutingEngine;

function __autoload($className)
{
    include '..\\'.$className . '.php';
}

final class App
{
	/**
	 * @var string
	 */
	private static $uri;

	/**
	 *
	 * The AppConstructor is the reads the requestUri store it and calls the routingMethod
	 *
	 * @return void
	 */
	public function __construct()
	{
		//set the uri
			if(isset($_SERVER['PATH_INFO'])){

				self::$uri = $_SERVER['PATH_INFO'];

			}elseif($_SERVER['SCRIPT_NAME'] === $_SERVER['PHP_SELF']){
				
				if($_SERVER['REQUEST_URI'] !== '/'){
					
					self::$uri = ltrim($_SERVER['REQUEST_URI'],dirname($_SERVER['PHP_SELF']));
				}else{

					self::$uri = $_SERVER['REQUEST_URI'];
				}
			}else{
				self::$uri = $_SERVER['REQUEST_URI'];
			}
		//call the routingMethod
			self::routing();
	}

	/**
	 *
	 * The routingMethod starts the session calls the RoutingEngine and echo the returnValue
	 *
	 * @return void
	 */
	private static function routing()
	{
		//if the URI calls not the index.php then start session and echo the Routing, else it echo that the user is in the root
			if(self::$uri !== $_SERVER['PHP_SELF'] && self::$uri !== '/'){	
				session_start();
				$routingEngine = new RoutingEngine;
				echo $routingEngine->handleRouting(self::$uri);
			}else{
				echo 'root';
			}
	}
		
}
new App();