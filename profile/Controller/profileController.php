<?php
namespace profile;

use Kernel\Controller;
use Kernel\HttpKernel\Request;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class profileController extends Controller
{
	/**
	 * @return View 
	 */
	public static function test()
	{
		$request = new Request();

		$get = 'nothing';
		if(isset($request->Get['g'])){
			$get = $request->Get['g'];
		}
		return View::render("templates:test:test.php",
							array(
								'hey1' => "hey_value",
								'was geht' => array('hey' => array(
																'nummer3' => $get, 
																'nummer4' => 'ja es klappt juhhuuu!!!'),
													'hey1' => "klappt auch hammer :)"
													),
								)
							);
	}
}