<?php
namespace test\Controller;

use Kernel\Controller;
use Kernel\HttpKernel\Request;
use Kernel\EntityManager\EntityManager;
use Kernel\Language;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 * @author Dennis Eisele  <dennis.eisele@online.de>
 */
class test2Controller extends Controller
{
	/**
	 * @return View 
	 */
	public function test2()
	{

		$request = new Request();
		$request->setCookie('hey', 'eins', 300);
		$Language = new Language('',"test");
		$output = $Language->translate("test.test1");
		
		return $this->render("test:templates:test:test1.php",
							array(
								'hey1' => 'heye',
								'wasgeht' => array('hey' => array(
																'nummer3' => 'heys', 
																'nummer4' => 'ja es klappt juhhuuu!!!'),
													'hey2' => array(
																'nummer3' => 'heyse', 
																'nummer4' => 'ja es klappt juhhuuu!!!'),
													),
								'hey3' => $output,
								)
							);
	}
}