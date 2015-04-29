<?php
namespace test\Controller;

use Kernel\Controller;
use Kernel\HttpKernel\Request;
use Tools\Files\Upload\FileUpload;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class DragDropFileUploadController extends Controller
{
	/**
	 * @return View 
	 */
	public function upload()
	{
		$request = new Request();
		$message = '';
		//fileUpload
			if(isset($request->files['file'])){
				$upload = new FileUpload('img',$request->files['file'], $fileExtensions = array('ra'), $mimeTypes = array('audio/x-pn-realaudio-plugin'), $useFieldTypes = array('image'));
				if($upload->upload()){
					$message =  "Uploaden ist geglückt!";
				}else{
					$message =   "Uploaden fehlgeschlagen";
				}
			}
		return $this->JsonResponse(array('message' => $message));
	}
}