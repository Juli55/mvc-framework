<?php
	//include library files
		require_once( 'lib/Facebook/FacebookSession.php');
		require_once( 'lib/Facebook/FacebookRequest.php' );
		require_once( 'lib/Facebook/FacebookResponse.php' );
		require_once( 'lib/Facebook/FacebookSDKException.php' );
		require_once( 'lib/Facebook/FacebookRequestException.php' );
		require_once( 'lib/Facebook/FacebookRedirectLoginHelper.php');
		require_once( 'lib/Facebook/FacebookAuthorizationException.php' );
		require_once( 'lib/Facebook/GraphObject.php' );
		require_once( 'lib/Facebook/GraphUser.php' );
		require_once( 'lib/Facebook/GraphSessionInfo.php' );
		require_once( 'lib/Facebook/Entities/AccessToken.php');
		require_once( 'lib/Facebook/HttpClients/FacebookCurl.php' );
		require_once( 'lib/Facebook/HttpClients/FacebookHttpable.php');
		require_once( 'lib/Facebook/HttpClients/FacebookCurlHttpClient.php');
	//use libs
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

	session_start();

	$app_id = '';
	$app_secret = '';
	$redirect_url = '/login';

	FacebookSession::setDefaultApplication($app_id, $app_secret);
	$helper = new FacebookRedirectLoginHelper($redirect_url);
	$sess = $helper-YgetSessionFromRedirect();
	if(isset($sess)){
		$request = new FacebookRequest($sess, 'GET', '/me');
		$response = $request->execute();
		$graph = $response->getGraphObject(GraphUser::classname());
		$name = $graph->getName();
		echo "hi $name";

	}else{
		echo "<a href='".$helper->getLoginUrl()."'>Login with facebook</a>";
	}
?>