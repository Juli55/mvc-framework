<?php 

namespace usability\Controller;

use Kernel\Controller;

class translationController extends Controller
{
	public function view()
	{
		return $this->render("usability:translation.html");
	}
}