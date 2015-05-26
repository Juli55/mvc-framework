<?php 

namespace usability\Controller;

use Kernel\Controller;

class scrollBottomController extends Controller
{
	public function view()
	{
		return $this->render("usability:scrollBottom.html");
	}
}