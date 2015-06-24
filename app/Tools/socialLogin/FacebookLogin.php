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
	public function login($appId, $appSecret, $redirectUrl)
	{
		$request = new Request();
		$redirectUrl = 'http://'.$_SERVER['HTTP_HOST'].$redirectUrl;

		FacebookSession::setDefaultApplication($appId, $appSecret);
		$helper = new FacebookRedirectLoginHelper($redirectUrl);
		try {
		  $session = $helper->getSessionFromRedirect();
		} catch(FacebookRequestException $ex) {
		  // When Facebook returns an error
		} catch(\Exception $ex) {
		  // When validation fails or other local issues
		}
		if($session){
			$request = new FacebookRequest($session, 'GET', '/me');
			$response = $request->execute();
			$graph = $response->getGraphObject(GraphUser::classname());
			$name = $graph->getName();
			echo $name;
		}else{
			echo "<a href='".$helper->getLoginUrl()."'>Login with facebook</a>";
		}
	}
}