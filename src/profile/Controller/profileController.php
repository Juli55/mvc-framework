<?php
namespace profile\Controller;

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
	public function test($eins,$zwei)
	{
		$request = new Request();
		$get = 'nothing';
		if(isset($request->Get['eins'])){
			$get = $request->Get['eins'];
		}


		return $this->render("profile:default.html",
							array(
								'hey1' => $get,
								'was geht' => array('hey' => array(
																'nummer3' => $get, 
																'nummer4' => 'ja es klappt juhhuuu!!!'),
													'hey2' => "klappt auch hammer :)"
													),
								'hey3' => 'joho1',
								)
							);
	}
}