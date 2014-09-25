<?php
namespace profile\Controller;

use Kernel\Controller;
use Kernel\HttpKernel\Request;
use Kernel\EntityManager\EntityManager;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 * @author Dennis Eisele  <dennis.eisele@online.de>
 */
class profileController extends Controller
{
	/**
	 * @return View 
	 */
	public function test($eins,$zwei)
	{

		$em = new EntityManager;

		$entity= $em->getEntity("profile:user");
		$entity->setGender(2);
		$entity->setFocusing(3);
		$em->persist($entity);
		$em->flush();
		$request = new Request();
		$get = 'nothing';
		if(isset($request->Get['g'])){
			$get = $request->Get['g'];
		}

		return $this->render("profile:default.html",
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