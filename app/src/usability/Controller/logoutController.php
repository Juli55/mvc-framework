<?php 

namespace usability\Controller;

use Kernel\Controller;
use Tools\Authentication\Security;

class logoutController extends Controller
{
	public function view()
	{
		$Security = new Security();
		$Security->logout();
		header('Location:/authentication');
		return $this->render("usability:authentication.html");
	}
}