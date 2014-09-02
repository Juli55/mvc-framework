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

							'idea'	  => array(
											'pattern'		=> 'idea/{idea}/{idea2}',
											'controller'	=> 'ideaController',
											'action'	 	=> 'test',
											'dir'			=> 'idea'
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