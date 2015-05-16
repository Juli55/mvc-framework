<?php 

namespace usability\Controller;

use Kernel\Controller;

class importController extends Controller
{
	public function view()
	{
		return $this->render("usability:importController.html");
	}
}