<?php

namespace Config;

/**
 * @author Julian Bertsch <Julian.bertch42@gmail.com>
 * @author Dennis Eisele  <dennis.eisele@online.de>
 */
class Routing
{


	/**
	 * @return void
	 */
	public static function init()
	{
		self::$routing <<<EOD
---
								test: 
										-	pattern 	: /test
											controller  : testController
											action	    : test
											srcFolder   : test
											security	: false
										
								test1:
										-	pattern 	: /test1
											controller 	: test1Controller
											action	 	: test1
											srcFolder	: test
											security	: false
...
EOD;


	}

	/**
	 * @return array
	 */
	public static function getRouting()
	{
		return self::$routing;
	}
}