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
	 * @return View 
	 */
	protected function render($template_encode, array $parameters = array())
	{
		return View::render($template_encode, $parameters);
	}
}