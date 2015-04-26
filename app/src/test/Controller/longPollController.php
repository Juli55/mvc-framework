<?php
namespace test\Controller;

use Kernel\Controller;
use Kernel\EntityManager\EntityManager;
use Kernel\HttpKernel\Request;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class longPollController extends Controller
{
	/**
	 * @return View 
	 */
	public function longpoll()
	{
		$em  = new EntityManager;
		//$em->getEntity('test:User')->
		$request = new Request();
		return $this->JsonResponse(
							array(
								'test' => 'heye'
								)
							);
	}
}