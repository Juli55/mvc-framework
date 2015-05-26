<?php 

namespace usability\Controller;

use Kernel\Controller;
use Kernel\HttpKernel\Request;
use src\usability\Form\testValidation;

class validationController extends Controller
{
	public function view()
	{
		$request = new Request();
		$testValidation = new testValidation();
		$validation = $testValidation->testValidate($request->post);
		return $this->JsonResponse($validation);
	}
}