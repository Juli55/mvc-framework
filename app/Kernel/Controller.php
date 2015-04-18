<?php

namespace Kernel;

use Kernel\View;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 * @author Dennis Eisele  <dennis.eisele@online.de>
 */
class Controller
{
	/**
	 *
	 * The renderMethod calls the renderMethod from View
	 *
	 * @param string $templateEncode
	 * @param array $parameters
	 *
	 * @return string 
	 */
	protected function render($templateEncode, $parameters = array())
	{
		return View::render($templateEncode, $parameters);
	}

	/**
	 * 
	 * The JsonResponse returns an Array in Json
	 * 
	 * @param array $parameters
	 * 
	 * @return string
	 */
	protected function JsonResponse($parameters)
	{
		return json_encode($parameters, JSON_FORCE_OBJECT);
	}
}  	
