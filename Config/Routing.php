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
											'pattern' 	 => 'profile/{profile}/',
											'controller' => 'profileController',
											'action'	 => 'test',
											'dir'		 => '/profile/Controller/'
										),
							'project' => array(
											'pattern' 			=> 'project/{project}',
											'controller' 		=> 'projectController',
											'action'	 		=> 'indexAction',
											'dir'				=> '/project/Controller/'
										),
							'idea'	  => array(
											'pattern'		=> 'idea/{ idea }',
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
