<?php
namespace test\Controller;

use Kernel\Controller;
use Kernel\HttpKernel\Request;

use Tools\Files\Upload\FileUpload;

use Kernel\EntityManager\EntityManager;
use src\test\Form\testValidation;


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
		$testValidation = new testValidation();
		$validation = $testValidation->testValidate();
		return $this->JsonResponse($validation);
	}
}