<?php
namespace test\Controller;

use Kernel\Controller;
use Kernel\HttpKernel\Request;

use Tools\Files\Upload\FileUpload;

use Kernel\EntityManager\EntityManager;


/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 * @author Dennis Eisele  <dennis.eisele@online.de>
 */
class test1Controller extends Controller
{
	/**
	 * @return View 
	 */
	public function test1()
	{
		$request = new Request();
		$request->setCookie('hey', 'eins', 300);
		

		return $this->render("test:templates:default.html",
							array(
								'hey1' => 'heye',
								'wasgeht' => array('hey' => array(
																'nummer3' => 'heys', 
																'nummer4' => 'ja es klappt juhhuuu!!!'),
													'hey2' => array(
																'nummer3' => 'heyse', 
																'nummer4' => 'ja es klappt juhhuuu!!!'),
													),
								'hey3' => 'joho1',
								)
							);
	}
}