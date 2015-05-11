<?php 

namespace usability\Controller;

use Kernel\Controller;

class usabilityController extends Controller
{
	public function usability()
	{
		return $this->render("usability:setVariable.html");
	}
}