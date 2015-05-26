<?php 

namespace usability\Controller;

use Kernel\Controller;

class renderController extends Controller
{
	public function view()
	{
		return $this->render("usability:render.html");
	}
}