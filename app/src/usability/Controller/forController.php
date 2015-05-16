<?php 

namespace usability\Controller;

use Kernel\Controller;

class forController extends Controller
{
	public function view()
	{
		return $this->render("usability:for.html",
							array(
								'array' => array('hey' => array(
																'name' => 'name1'),
												 'hey2' => array(
																'name' => 'name2'),
													),
								)
							);
	}
}