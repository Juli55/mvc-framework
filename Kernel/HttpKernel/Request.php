<?php
namespace Kernel\HttpKernel;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class Request
{
	/**
	 * @var array $_POST 
	 */
	public $Post;

	/**
	 * @var array $_GET 
	 */
	public $Get;

	/**
	 * @var array $_COOKIE 
	 */
	public $Cookie;

	/**
	 * @var array $_FILES 
	 */
	public $Files;

	/**
	 * @var array $_SERVER 
	 */
	public $Server;

	/**
	 * @var array $_SESSION
	 */
	public $Session;

	/**
	 * Get the Custom Parameters and call the init method with this parameter
	 *
	 * @param array $Post
	 * @param array $Get
	 * @param array $Cookie
	 * @param array $Files
	 * @param array $Server
	 * @param array $Session
	 */
	public function __construct(array $Post = array(), array $Get = array(), array $Cookie = array(), array $Files = array(), array $Server = array(), array $Session = array()){		

		self::init($Post, $Get, $Cookie, $Files, $Server, $Session);
	}

	/**
	 * Take the custom Parameters and call the getFromGlobal method with this parameters
	 *
	 * @param array $Post
	 * @param array $Get
	 * @param array $Cookie
	 * @param array $Files
	 * @param array $Server
	 * @param array $Session
	 */
	private function init(array $Post, array $Get, array $Cookie, array $Files, array $Server,array $Session){

		self::getFromGlobal($Post, $Get, $Cookie, $Files, $Server);
	}

	/**
	 * Set the Variables with the Global Parametres if the Custom is empty 
	 *
	 * @param array $Post
	 * @param array $Get
	 * @param array $Cookie
	 * @param array $Files
	 * @param array $Server
	 * @param array $Session
	 */
	private function getFromGlobal(array $Post, array $Get, array $Cookie, array $Files, array $Server){
		

		
		$this->Post = $_POST;
		if(!empty($Post)){
			$this->Post = $Post;
		}

		$this->Get = $_GET;
		if(!empty($Get)){
			$this->Get = $Get;
		}

		$this->Cookie = $_COOKIE;
		if(!empty($post)){
			$this->cookie = $post;
		}

		$this->Files = $_FILES;
		if(!empty($Files)){
			$this->Files = $Files;
		}

		$this->Server = $_SERVER;
		if(!empty($Server)){
			$this->Server = $Server;
		}

		$this->Session = $_SESSION;
		if(!empty($Session)){
			$this->Session = $Session;
		}
	}

	/**
	 * Set the intern $Post variable and call the method setGlobalPost to set the global variable
	 * 
	 * @param $key
	 * @param $value
	 */
	public function setPost($key,$value){
		$this->Post[$key] = $value;
		self::setGlobalPost($key,$value);
	}

	/**
	 * Set the the global variable
	 * 
	 * @param $key
	 * @param $value
	 */
	private static function setGlobalPost($key,$value){

		$_POST[$key] = $value;
	}

	/**
	 * Set the intern $Get variable and call the method setGlobalGet to set the global variable
	 * 
	 * @param $key
	 * @param $value
	 */
	public function setGet($key,$value){
		
		$this->Get[$key] = $value;
		self::setGlobalGet($key,$value);
	}

	/**
	 * Set the the global variable
	 * 
	 * @param $key
	 * @param $value
	 */
	private static function setGlobalGet($key,$value){

		$_GET[$key] = $value;
	}

	/**
	 * Set the intern $Cookie variable and call the method setGlobalCookie to set the global variable
	 * 
	 * @param $key
	 * @param $value
	 */
	public function setCookie($key,$value){
		$this->Cookie[$key] = $value;
		self::setGlobalCookie($key,$value);
	}

	/**
	 * Set the the global variable
	 * 
	 * @param $key
	 * @param $value
	 */
	private static function setGlobalCookie($key,$value){

		$_COOKIE[$key] = $value;
	}

	/**
	 * Set the intern $Files variable and call the method setGlobalFiles to set the global variable
	 * 
	 * @param $key
	 * @param $value
	 */
	public function setFiles($key,$value){
		$this->Files[$key] = $value;
		self::setGlobalFiles($key,$value);
	}

	/**
	 * Set the the global variable
	 * 
	 * @param $key
	 * @param $value
	 */
	private static function setGlobalFiles($key,$value){

		$_FILES[$key] = $value;
	}

	/**
	 * Set the intern $Server variable and call the method setGlobalServer to set the global variable
	 * 
	 * @param $key
	 * @param $value
	 */
	public function setServer($key,$value){
		$this->Server[$key] = $value;
		self::setGlobalServer($key,$value);
	}

	/**
	 * Set the the global variable
	 * 
	 * @param $key
	 * @param $value
	 */
	private static function setGlobalServer($key,$value){

		$_SERVER[$key] = $value;
	}

	/**
	 * Set the intern $Session variable and call the method setGlobalSession to set the global variable
	 * 
	 * @param $key
	 * @param $value
	 */
	public function setSession($key,$value){
		$this->Session[$key] = $value;
		self::setGlobalSession($key,$value);
	}

	/**
	 * Set the the global variable
	 * 
	 * @param $key
	 * @param $value
	 */
	private static function setGlobalSession($key,$value){

		$_SESSION[$key] = $value;
	}
}