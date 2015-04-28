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
		$em->getEntity('test:User');
		$sec = 5;
		do{
			sleep(1);
			$dbData = $em->find('first_name', 'julian1');
			$sec--;
			if($dbData){
				break;
			}
		}while($sec);
		$request = new Request();
		return $this->JsonResponse(
							array(
								'name' => $dbData->getFirst_name()
								)
							);
	}
}