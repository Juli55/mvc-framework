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
									'identificator'  =>	' ',
									'passwordKey'	 =>	' ',
									'entityShortcut' =>	'test:user',
									'redirectTo'	 => ' '
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
