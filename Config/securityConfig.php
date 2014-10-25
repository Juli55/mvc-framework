<?php

namespace Config;

/**
 * @author Julian Bertsch <Julian.bertch42@gmail.com>
 */
class securityConfig
{
	/**
	 * @var array
	 */
	private static $securityConfig  = array();

	/**
	 * @return void
	 */
	public static function init()
	{
		self::$securityConfig = array(
									'identificator'  =>	'email',
									'passwordKey'	 =>	'password',
									'entityShortcut' =>	'profile:user',
									'redirectTo'	 => 'authentification'
								);
	}

	/**
	 * @return array
	 */
	public static function getSecurityConfig()
	{
		return self::$securityConfig;
	}
}
