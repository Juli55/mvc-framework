<?php 

namespace usability\Controller;

use Kernel\Controller;

class setVariableController extends Controller
{
	public function view()
	{
		return $this->render("usability:setVariable.html",
							array('controllerVariable' => 'controllerVariableValue'
								)
							);
	}
}