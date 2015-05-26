<?php 

namespace usability\Controller;

use Kernel\Controller;

class menuController extends Controller
{
	public function view()
	{
		return $this->render("usability:menu.html");
	}
}