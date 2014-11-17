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

		

		return $this->render("test:templates:default.html",
							array(
								'hey1' => 'hey',
								'was geht' => array('hey' => array(
																'nummer3' => 'hey', 
																'nummer4' => 'ja es klappt juhhuuu!!!'),
													'hey2' => "klappt auch hammer :)"
													),
								'hey3' => 'joho1',
								)
							);
	}
}