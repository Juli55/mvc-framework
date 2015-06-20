<?php
namespace usability\Controller;

use Kernel\Controller;
use Tools\socialLogin\Facebook\FacebookSession;
use Tools\socialLogin\Facebook\FacebookRedirectLoginHelper;
use Tools\socialLogin\Facebook\FacebookRequest;
use Tools\socialLogin\Facebook\FacebookResponse;
use Tools\socialLogin\Facebook\FacebookSDKException;
use Tools\socialLogin\Facebook\FacebookRequestException;
use Tools\socialLogin\Facebook\FacebookAuthorizationException;
use Tools\socialLogin\Facebook\GraphObject;
use Tools\socialLogin\Facebook\GraphUser;
use Tools\socialLogin\Facebook\GraphSessionInfo;
use Tools\socialLogin\Facebook\FacebookHttpable;
use Tools\socialLogin\Facebook\FacebookCurlHttpClient;
use Tools\socialLogin\Facebook\FacebookCurl;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class fbLoginController extends Controller
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
		return $this->render("usability:fblogin.html");
	}
}