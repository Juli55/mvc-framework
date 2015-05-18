<?php 

namespace usability\Controller;

use Kernel\Controller;
use Kernel\EntityManager\EntityManager;

class dbController extends Controller
{
	public function view($entryMsg)
	{
		//init EntityManager
			$em = new EntityManager;
			$entity = $em->getEntity("usability:test");
		//set an databaseTable entry
			$entity->setTest1($entryMsg);
			$em->persist($entity);
			$em->flush();
		//select an entry
			$entryObject = $em->find('id',1);
		//select all entries by an proberty
			$entryObjects = $em->findAll('test1', 'entry');
		return $this->render("usability:db.html",
							array(
								'entryMsg' => $entryMsg,
								'entryObject' => $entryObject,
								'entryObjects' => $entryObjects
								));
	}
}