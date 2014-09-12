<?php
namespace useEntityManager\Controller;

use Kernel\Controller;
use Kernel\EntityManager;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class useEntityManagerController extends Controller
{
	/**
	 * @return View 
	 */
	public function test($parameter1,$parameter2)
	{
		//instance the EntityManager
		$em = new EntityManager();

		// get the Repository and set the Entity form dir useEntityManager in dir src and take the entity user from the entity dir
		$repository = $em->getRepository('useEntityManager:User');


		//select
			//select all
			$repository->findAll();

			//select one and find them by Title but Title has to be in the Entity and the method will be generated dynamic
			$repository->findOneByTitle('Hey');

		//read
			//get the Title value from the selected
			$repository->getTitle();

		//set some but only if one selected

			//here it set the value in the entity class
			$repository->setTitle('hey');

			//here it takes the updates and update the database entry
			$em->flush();


	}
}