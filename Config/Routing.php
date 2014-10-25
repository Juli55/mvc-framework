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
							'authentification' => array(
											'pattern' 	 => '/authentification',
											'controller' => 'loginController',
											'action'	 => 'login',
											'srcFolder'	 => 'authentification'
											'security'	 =>  false
										),
							'registration' => array(
											'pattern' 	 => '/registration/{ parameter }',
											'controller' => 'registerController',
											'action'	 => 'register',
											'srcFolder'	 => 'registration',
											'security'	 =>  false
										),
							'profile' => array(
											'pattern' 	 => '/profile/{profile}/{variable}',
											'controller' => 'profileController',
											'action'	 => 'test',
											'srcFolder'	 => 'profile'
										),
							'project' => array(
											'pattern' 			=> 'project/{project}/{hey}',
											'controller' 		=> 'projectController',
											'action'	 		=> 'indexAction',
											'srcFolder'			=> 'project'
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