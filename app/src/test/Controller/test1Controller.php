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
class test1Controller extends Controller
{
	/**
	 * @return View 
	 */
	public function test1()
	{
		$em  = new EntityManager;
		//$em->getEntity('test:User')->
		$request = new Request();
		$request->setCookie('hey', 'eins', 300);
		$get = 'nothing';
		//fileUpload
			if(isset($request->files['file'])){
				$upload = new FileUpload('img',$request->files['file'], $fileExtensions = array('ra'), $mimeTypes = array('audio/x-pn-realaudio-plugin'), $useFieldTypes = array('image'));
				if($upload->upload()){
					echo  "Uploaden ist geglückt!";
				}else{
					echo  "Uploaden fehlgeschlagen";
				}
			}
		if(session_id())
		{
		    session_close();
		}
		
		$message = null;
		while(!$message)
		{
		    sleep(5);
		    $message = liesNeueNachichtAusDatenbank();
		}
		return $this->render("test:templates:default.html",
							array(
								'hey1' => 'heye',
								'wasgeht' => array('hey' => array(
																'nummer3' => 'heys', 
																'nummer4' => 'ja es klappt juhhuuu!!!'),
													'hey2' => array(
																'nummer3' => 'heyse', 
																'nummer4' => 'ja es klappt juhhuuu!!!'),
													),
								'hey3' => 'joho1',
								)
							);
	}
}