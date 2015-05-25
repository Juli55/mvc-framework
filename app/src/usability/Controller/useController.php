<?php 

namespace usability\Controller;

use Kernel\Controller;

class useController extends Controller
{
	public function view()
	{
		return $this->render("usability:use.html");
	}
}