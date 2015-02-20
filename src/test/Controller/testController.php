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
class testController extends Controller
{
	/**
	 * @return View 
	 */
	public function test($hey)
	{
		
		$em = new EntityManager;

		$entity= $em->getEntity("test:user");
		$entity->setfirst_namE(2);
		$entity->setPassword(3);
		$request = new Request();
		$get = 'nothing';
		if(isset($request->files['eins'])){
			$upload = new FileUpload('img',$request->files['eins']);
			if($upload->upload()){
				echo  "Uploaden ist geglückt!";
			}else{
				echo  "Uploaden fehlgeschlagen";
			}
		}
		
		return $this->render("test:default.html",
							array(
								'hey' => $entity,
								'wasgeht' => array('hey' => array(
																'nummer3' => 'hey', 
																'nummer4' => 'ja es klappt juhhuuu!!!'),
													'hey2' => array(
																'nummer3' => 'hey2', 
																'nummer4' => 'ja es klappt juhhuuu!!!')
													),
								'hey3' => 'joho1',
								)
							);
	}
}