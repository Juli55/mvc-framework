<?php
namespace profile\Controller;

use Kernel\Controller;
use Kernel\HttpKernel\Request;

use Tools\Files\Upload\FileUpload;

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
		if(isset($request->Files['eins'])){
			$upload = new FileUpload('img',$request->Files['eins']);
			if($upload->upload()){
				echo  "Uploaden ist geglückt!";
			}else{
				echo  "Uploaden fehlgeschlagen";
			}
		}

		return $this->render("profile:default.html",
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