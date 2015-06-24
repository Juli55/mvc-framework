<?php
namespace usability\Controller;

require '../vendor/facebook/php-sdk-v4/autoload.php';
use Kernel\Controller;
use Tools\socialLogin\FacebookLogin;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class fbLoginController extends Controller
{
	public function login()
	{
		$app_id = '897845620276539';
		$app_secret = '6766dbfd6ed7a4b556cf62e5c35179d4';
		$redirect_url = '/fblogin';
		$FacebookLogin = new FacebookLogin;
		$FacebookLogin->login($app_id, $app_secret, $redirect_url);
	
		return $this->render("usability:fblogin.html");
	}
}