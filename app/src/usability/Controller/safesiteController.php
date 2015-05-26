<?php 

namespace usability\Controller;

use Kernel\Controller;

class safesiteController extends Controller
{
	public function view()
	{
		return $this->render("usability:safesite.html");
	}
}