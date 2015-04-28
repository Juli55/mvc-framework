<?php
namespace src\test\Poll;

use Kernel\Controller;
use Kernel\EntityManager\EntityManager;
/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class dbPoll extends Controller
{
	/**
	 * @return View 
	 */
	public function poll()
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
		return $this->JsonResponse(
							array(
								'name' => $dbData->getFirst_name()
								)
							);
	}
}