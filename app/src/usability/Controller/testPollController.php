<?php 

namespace usability\Controller;

use Kernel\Controller;

class testPollController extends Controller
{
	public function view()
	{
		return $this->render("usability:testPoll.html");
	}
}