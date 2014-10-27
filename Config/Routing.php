<?php

namespace Config;

/**
 * @author Julian Bertsch <Julian.bertch42@gmail.com>
 */
class Routing
{
	/**
	 * @var array
	 */
	public static $routing = array();

	/**
	 * @return void
	 */
	public static function init()
	{
		self::$routing = array(
							'test' => array(
											'pattern' 	 => '/test',
											'controller' => 'testController',
											'action'	 => 'test',
											'srcFolder'	 => 'test',
											'security'	 =>  false
										),
						);
	}

	/**
	 * @return array
	 */
	public static function getRouting()
	{
		return self::$routing;
	}
}