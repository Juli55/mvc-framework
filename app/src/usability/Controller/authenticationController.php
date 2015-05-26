<?php 

namespace usability\Controller;

use Kernel\Controller;
use Tools\Authentication\Security;

class authenticationController extends Controller
{
	public function view()
	{
		$Security = new Security();
		if(!$Security->login()){
			$Security->errorNumber;
		}else{
			header('Location:/safesite');
		}
		return $this->render("usability:authentication.html");
	}
}