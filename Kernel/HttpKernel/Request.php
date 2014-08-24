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
	 * Get the Custom Parameters and call the init method with this parameter
	 *
	 * @param array $Post
	 * @param array $Get
	 * @param array $Cookie
	 * @param array $Files
	 * @param array $Server
	 */
	public function __construct(array $Post = array(), array $Get = array(), array $Cookie = array(), array $Files = array(), array $Server = array()){		

		self::init($Post, $Get, $Cookie, $Files, $Server);
	}

	/**
	 * Take the custom Parameters and call the getFromGlobal method with this parameters
	 *
	 * @param array $Post
	 * @param array $Get
	 * @param array $Cookie
	 * @param array $Files
	 * @param array $Server
	 */
	private function init(array $Post, array $Get, array $Cookie, array $Files, array $Server){

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
	}

	/**
	 * Set the intern $Post variable and call the method setGlobalPost to set the global variable
	 * 
	 * @param array $Post
	 */
	public function setPost(array $Post){
		$this->Post[] = $Post;
		self::setGlobalPost($Post);
	}

	/**
	 * Set the the global variable
	 * 
	 * @param array $Post
	 */
	private static function setGlobalPost(array $Post){

		$_POST[] = $Post;
	}

	/**
	 * Set the intern $Get variable and call the method setGlobalGet to set the global variable
	 * 
	 * @param array $Get
	 */
	public function setGet(array $Get){
		
		$this->Get[] = $Get;
		self::setGlobalGet($Get);
	}

	/**
	 * Set the the global variable
	 * 
	 * @param array $Get
	 */
	private static function setGlobalGet(array $Get){

		$_GET[] = $Get;
	}

	/**
	 * Set the intern $Cookie variable and call the method setGlobalCookie to set the global variable
	 * 
	 * @param array $Cookie
	 */
	public function setCookie(array $Cookie){
		$this->Cookie[] = $Cookie;
		self::setGlobalCookie($Cookie);
	}

	/**
	 * Set the the global variable
	 * 
	 * @param array $Cookie
	 */
	private static function setGlobalCookie(array $Cookie){

		$_COOKIE[] = $Cookie;
	}

	/**
	 * Set the intern $Files variable and call the method setGlobalFiles to set the global variable
	 * 
	 * @param array $Files
	 */
	public function setFiles(array $Files){
		$this->Files[] = $Files;
		self::setGlobalFiles($Files);
	}

	/**
	 * Set the the global variable
	 * 
	 * @param array $Files
	 */
	private static function setGlobalFiles(array $Files){

		$_FILES[] = $Files;
	}

	/**
	 * Set the intern $Server variable and call the method setGlobalServer to set the global variable
	 * 
	 * @param array $Server
	 */
	public function setServer(array $Server){
		$this->Server[] = $Server;
		self::setGlobalServer($Server);
	}

	/**
	 * Set the the global variable
	 * 
	 * @param array $Server
	 */
	private static function setGlobalServer(array $Server){

		$_SERVER[] = $Server;
	}
}