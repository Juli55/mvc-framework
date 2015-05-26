<?php 

namespace usability\Controller;

use Kernel\Controller;

class includeController extends Controller
{
	public function view()
	{
		return $this->render("usability:include.html");
	}
}