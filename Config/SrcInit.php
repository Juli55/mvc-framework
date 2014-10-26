<?php

namespace Config;

/**
 * @author Julian Bertsch <Julian.bertch42@gmail.com>
 */
class SrcInit
{
	/**
	 * @var array
	 */
	private static $srcFolder = array();

	/**
	 * @return void
	 */
	public static function init()
	{
		self::$srcFolder = array(
							'profile' 			=> 'profile',
							'project' 			=> 'project',
							'authentification'	=> 'authentification',
							'registration'		=> 'registration'
						);
	}

	/**
	 * @return array
	 */
	public static function getSrcFolder()
	{
		return self::$srcFolder;
	}
}