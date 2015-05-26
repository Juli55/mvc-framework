<?php
namespace usability\Controller;

use Kernel\Controller;
use Kernel\HttpKernel\Request;
use Tools\Files\Upload\FileUpload;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class FileUploadController extends Controller
{
	public function upload()
	{
		$request = new Request();
		$message = '';
		//fileUpload
			if(isset($request->files['file'])){
				$upload = new FileUpload('files', $request->files['file']);
				if($upload->upload()){
					$message =  "Uploaden ist geglückt!";
				}else{
					$message =   "Uploaden fehlgeschlagen";
				}
			}
		return $this->render("usability:fileupload.html",
							array(
								'message' => $message
								)
							);
	}
}