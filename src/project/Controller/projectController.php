<?php
namespace project\Controller;

use Kernel\HttpKernel\Request;
use Kernel\View;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class projectController
{
	/**
	 * @return View 
	 */
	public static function indexAction($eins,$zwei)
	{
		$request = new Request();
		$get = 'nothing';
		if(isset($request->Get['g'])){
			$get = $request->Get['g'];
		}

		return View::render("profile:templates:test:test.php",
							array(
								'hey1' => "hey_value",
								'kk' => array('hey' => array(
																'nummer3' => $get, 
																'nummer4' => $eins
															),
													'hey1' => "klappt auch hammer :)"
													),
								)
							);
	}
}