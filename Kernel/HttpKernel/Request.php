<?php

namespace Kernel\HttpKernel;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class Request
{
	/**
	 * @var array
	 */
	public $post;

	/**
	 * @var array
	 */
	public $get;

	/**
	 * @var array
	 */
	public $cookie;

	/**
	 * @var array
	 */
	public $files;

	/**
	 * @var array
	 */
	public $server;

	/**
	 * @var array
	 */
	public $session;

	/**
	 * get the custom Parameters and call the init method with this parameter
	 *
	 * @param array $post, $get, $cookie, $files, $server, $session
	 *
	 * @return void
	 */
	public function __construct(array $post = array(), array $get = array(), array $cookie = array(), array $files = array(), array $server = array(), array $session = array())
	{		
		self::init($post, $get, $cookie, $files, $server, $session);
	}

	/**
	 * Take the custom Parameters and call the getFromGlobal method with this parameters
	 *
	 * @param array $post, $get, $cookie, $files, $server, $session
	 *
	 * @return void
	 */
	private function init(array $post, array $get, array $cookie, array $files, array $server,array $session)
	{
		self::getFromGlobal($post, $get, $cookie, $files, $server);
	}

	/**
	 * Set the objectProbertys with the Values from Global or from params
	 *
	 * @param array $post, $get, $cookie, $files, $server, $session
	 *
	 * @return void
	 */
	private function getFromGlobal(array $post, array $get, array $cookie, array $files, array $server)
	{
		//set the objectProbertys			
			$this->post = $_POST;
			if(!empty($post)){
				$this->post = $post;
			}

			$this->get = $_GET;
			if(!empty($get)){
				$this->get = $get;
			}

			$this->cookie = $_COOKIE;
			if(!empty($post)){
				$this->cookie = $post;
			}

			$this->files = $_FILES;
			if(!empty($files)){
				$this->files = $files;
			}

			$this->server = $_SERVER;
			if(!empty($server)){
				$this->server = $server;
			}

			$this->session = $_SESSION;
			if(!empty($session)){
				$this->session = $session;
			}
	}

	/**
	 * Set the intern $post variable and call the method setGlobalPost to set the globalVariable
	 * 
	 * @param string $key, $value
	 *
	 * @return void
	 */
	public function setPost($key,$value)
	{
		$this->post[$key] = $value;
		self::setGlobalPost($key,$value);
	}

	/**
	 * Set the the globalVariable
	 * 
	 * @param string $key, $value
	 * 
	 * @return void
	 */
	private static function setGlobalPost($key,$value)
	{
		$_POST[$key] = $value;
	}

	/**
	 * Set the intern $get variable and call the method setGlobalGet to set the globalVariable
	 * 
	 * @param string $key, $value
	 *
	 * @return void
	 */
	public function setGet($key,$value)
	{		
		$this->get[$key] = $value;
		self::setGlobalGet($key,$value);
	}

	/**
	 * Set the the globalVariable
	 * 
	 * @param string $key, $value
	 *
	 * @return void
	 */
	private static function setGlobalGet($key,$value)
	{
		$_get[$key] = $value;
	}

	/**
	 * Set the intern $cookie variable and call the method setGlobalcookie to set the globalVariable
	 * 
	 * @param string $key, $value
	 *
	 * @return void
	 */
	public function setCookie($key,$value){
		$this->cookie[$key] = $value;
		self::setGlobalcookie($key,$value);
	}

	/**
	 * Set the the globalVariable
	 * 
	 * @param string $key, $value
	 *
	 * @return void
	 */
	private static function setGlobalCookie($key,$value)
	{
		$_cookie[$key] = $value;
	}

	/**
	 * Set the intern $files variable and call the method setGlobalFiles to set the globalVariable
	 * 
	 * @param string $key, $value
	 *
	 * @return void
	 */
	public function setFiles($key,$value)
	{
		$this->files[$key] = $value;
		self::setGlobalFiles($key,$value);
	}

	/**
	 * Set the the globalVariable
	 * 
	 * @param string $key, $value
	 *
	 * @return void
	 */
	private static function setGlobalFiles($key,$value)
	{

		$_files[$key] = $value;
	}

	/**
	 * Set the intern $server variable and call the method setGlobalServer to set the globalVariable
	 * 
	 * @param string $key, $value
	 *
	 * @return void
	 */
	public function setServer($key,$value)
	{
		$this->server[$key] = $value;
		self::setGlobalServer($key,$value);
	}

	/**
	 * Set the the globalVariable
	 * 
	 * @param string $key, $value
	 *
	 * @return void
	 */
	private static function setGlobalServer($key,$value)
	{
		$_server[$key] = $value;
	}

	/**
	 * Set the intern $session variable and call the method setGlobalSession to set the globalVariable
	 * 
	 * @param string $key, $value
	 *
	 * @return void
	 */
	public function setSession($key,$value)
	{
		$this->session[$key] = $value;
		self::setGlobalSession($key,$value);
	}

	/**
	 * Set the the globalVariable
	 * 
	 * @param string $key, $value
	 *
	 * @return void
	 */
	private static function setGlobalSession($key,$value)
	{
		$_session[$key] = $value;
	}
}