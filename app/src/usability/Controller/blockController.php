<?php 

namespace usability\Controller;

use Kernel\Controller;

class blockController extends Controller
{
	public function view()
	{
		return $this->render("usability:block.html");
	}
}