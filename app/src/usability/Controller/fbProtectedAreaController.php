<?php
namespace usability\Controller;

use Kernel\Controller;
use Kernel\HttpKernel\Request;
use Tools\socialLogin\FacebookLogin;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class fbProtectedAreaController extends Controller
{
	public function view()
	{
		$request = new Request();
		$accessToken = $request->session['facebook'];
		if(isset($accessToken)){
			$appId = '897845620276539';
			$appSecret = '6766dbfd6ed7a4b556cf62e5c35179d4';
			$FacebookLogin = new FacebookLogin;
			$login = $FacebookLogin->loginWithToken($accessToken, $appId, $appSecret);
			$graph = $FacebookLogin->graph;
		}else{
			header('Location:/fblogin');
		}
		return $this->render("usability:fbProtectedArea.html", array('name' => $graph->getName()));
	}
}