<?php 

namespace usability\Controller;

use Kernel\Controller;
use Tools\socialLogin\FacebookLogin;
use Kernel\HttpKernel\Request;

class fbLogoutController extends Controller
{
	public function logout()
	{
		$request = new Request();
		$accessToken = $request->session['facebook'];
		if(isset($accessToken)){
			unset($_SESSION['facebook']);
			header('Location:/fblogin');
		}
	}
}