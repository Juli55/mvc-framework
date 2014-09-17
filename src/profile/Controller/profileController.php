<?php
namespace profile\Controller;

use Kernel\Controller;
use Kernel\HttpKernel\Request;
use Tools\Files\Upload\FileUpload;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class profileController extends Controller
{
	/**
	 * @return View 
	 */
	public function test($eins,$zwei)
	{
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