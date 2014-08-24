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
							'profile' => array(
											'pattern' 	 => 'profile/profile/',
											'controller' => 'profileController',
											'dir'		 => '/profile/Controller/'
										),
							'project' => array(
											'pattern' 			=> 'project/project',
											'controller' 		=> 'projectController',
											'dir'				=> '/project'
										),
							'idea'	  => array(
											'pattern'		=> 'idea/',
											'controller'	=> 'ideaController',
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
