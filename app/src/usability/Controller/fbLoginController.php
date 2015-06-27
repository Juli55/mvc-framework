<?php
namespace usability\Controller;

use Kernel\Controller;
use Tools\socialLogin\FacebookLogin;
use Kernel\HttpKernel\Request;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class fbLoginController extends Controller
{
	public function login()
	{
		$appId 		= '897845620276539';
		$appSecret 	= '6766dbfd6ed7a4b556cf62e5c35179d4';
		if($this->checkLogin($appId, $appSecret)){
			header('Location:/fbchecklogin');
		}
		$redirectUrl 	= '/fblogin';
		$FacebookLogin 	= new FacebookLogin;
		$login 			= $FacebookLogin->login($appId, $appSecret, $redirectUrl);
		if($login){
			header('Location:/fbchecklogin');
		}else{
			echo "<a href='".$FacebookLogin->loginurl."'>Login with facebook</a>";
		}
	
		return $this->render("usability:fblogin.html");
	}

	private function checkLogin($appId, $appSecret)
	{
		$request = new Request;
		$accessToken = $request->session['facebook'];
		if(isset($accessToken)){
			//try to log in with accesstoken
				$FacebookLogin = new FacebookLogin;
				$login = $FacebookLogin->loginWithToken($accessToken, $appId, $appSecret);
				if($login){
					return true;
				}
		}
		return false;
	}
}