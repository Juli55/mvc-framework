<?php
namespace Tools\socialLogin;

require '../vendor/facebook/php-sdk-v4/autoload.php';
use Kernel\HttpKernel\Request;
use Facebook\FacebookSession;
use Facebook\FacebookRedirectLoginHelper;
use Facebook\FacebookRequest;
use Facebook\FacebookResponse;
use Facebook\FacebookSDKException;
use Facebook\FacebookRequestException;
use Facebook\FacebookAuthorizationException;
use Facebook\GraphObject;
use Facebook\GraphUser;
use Facebook\GraphSessionInfo;
use Facebook\FacebookHttpable;
use Facebook\FacebookCurlHttpClient;
use Facebook\FacebookCurl;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class FacebookLogin
{
	/**
	 * @var String
	 */
	public $loginurl;

	/**
	 * @var Object
	 */
	public $graph;

	/**
	 * get the custom Parameters and call the init method with this parameter
	 *
	 * @param String $appId, $appSecret, $redirectUrl
	 *
	 * @return true
	 */
	public function login($appId, $appSecret, $redirectUrl)
	{
		$redirectUrl = 'http://'.$_SERVER['HTTP_HOST'].$redirectUrl;
		$request = new Request();
		FacebookSession::setDefaultApplication($appId, $appSecret);
		$helper = new FacebookRedirectLoginHelper($redirectUrl);
		try {
		 $session = $helper->getSessionFromRedirect();
		} catch(FacebookRequestException $ex) {
		  // When Facebook returns an error
		} catch(\Exception $ex) {
		  // When validation fails or other local issues
		}
		$this->loginurl = $helper->getLoginUrl();
		if($session){
			$FacebookRequest = new FacebookRequest($session, 'GET', '/me');
			$response = $FacebookRequest->execute();
			$graph = $response->getGraphObject(GraphUser::classname());
			$name = $graph->getName();
			$accessToken = $session->getAccessToken();
			$request->setSession('facebook', (string) $accessToken);
			return true;
		}else{
			return false;
		}
	}

	public function loginWithToken($acces_token, $appId, $appSecret)
	{
		FacebookSession::setDefaultApplication($appId, $appSecret);
		$session = new FacebookSession($acces_token);
		$FacebookRequest = new FacebookRequest($session, 'GET', '/me');
		$response = $FacebookRequest->execute();
		$this->graph = $response->getGraphObject(GraphUser::classname());
		if($session){

			return true;
		}
		return false;
	}
}