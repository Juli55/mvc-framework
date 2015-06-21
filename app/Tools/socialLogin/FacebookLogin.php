<?php
namespace Tools\socialLogin;

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
	public function login()
	{
		$app_id = '897845620276539';
		$app_secret = '6766dbfd6ed7a4b556cf62e5c35179d4';
		$redirect_url = 'http://localhost:8081/fblogin';

		FacebookSession::setDefaultApplication($app_id, $app_secret);
		$helper = new FacebookRedirectLoginHelper($redirect_url);
		$sess = $helper->getSessionFromRedirect();
		if(isset($sess)){
			$request = new FacebookRequest($sess, 'GET', '/me');
			$response = $request->execute();
			$graph = $response->getGraphObject(GraphUser::classname());
			$name = $graph->getName();
			echo "hi $name";

		}else{
			echo "<a href='".$helper->getLoginUrl()."'>Login with facebook</a>";
		}
	}
}