<?php 

namespace usability\Controller;

use Kernel\Controller;

class fillElementController extends Controller
{
	public function view()
	{
		return $this->render("usability:fillElement.html");
	}
}