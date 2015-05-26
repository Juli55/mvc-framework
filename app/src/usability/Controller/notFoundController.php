<?php 

namespace usability\Controller;

use Kernel\Controller;

class notFoundController extends Controller
{
	public function view()
	{
		return $this->render("usability:404.html");
	}
}