<?php 

namespace usability\Controller;

use Kernel\Controller;
use Kernel\EntityManager\EntityManager;

class dbController extends Controller
{
	public function view($entryMsg)
	{
		//set an databaseTable entry
			$em = new EntityManager;
			$entity= $em->getEntity("usability:test");
			$entity->setTest1($entryMsg);
			$em->persist($entity);
			$em->flush();
		return $this->render("usability:db.html",
							array(
								'entryMsg' => $entryMsg
								));
	}
}