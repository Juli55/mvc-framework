<?php 

namespace usability\Controller;

use Kernel\Controller;

class validationTestController extends Controller
{
	public function view()
	{
		return $this->render("usability:validationTest.html");
	}
}