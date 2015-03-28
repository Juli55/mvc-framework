<?php 

namespace testAmend\Controller;

use Kernel\Controller;

class testAmendController extends Controller
{
	public function testAmend()
	{
		return $this->render("testAmend:default.html");
	}
}