<?php
namespace profile\Controller;

use Kernel\HttpKernel\Request;
use Kernel\View;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class profileController
{
	/**
	 * @return View 
	 */
	public static function test($eins,$zwei)
	{
		$request = new Request();
		$get = 'nothing';
		if(isset($request->Get['g'])){
			$get = $request->Get['g'];
		}

		return View::render("templates:default.html",
							array(
								'hey1' => $zwei,
								'was geht' => array('hey' => array(
																'nummer3' => $eins, 
																'nummer4' => 'ja es klappt juhhuuu!!!'),
													'hey2' => "klappt auch hammer :)"
													),
								)
							);
	}
}