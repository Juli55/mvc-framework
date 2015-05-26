<?php 

namespace usability\Controller;

use Kernel\Controller;

class patternVariableController extends Controller
{
	public function view($patternVariable)
	{
		return $this->render("usability:patternVariable.html",
							array(
								'patternVariable' => $patternVariable
								));
	}
}