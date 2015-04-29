<?php
namespace test\Controller;

use Kernel\Controller;
use Kernel\HttpKernel\Request;
use Tools\Files\Upload\FileUpload;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class DragDropFileUploadFrontEndController extends Controller
{
	/**
	 * @return View 
	 */
	public function view()
	{
		return $this->render("test:drag-drop-file-upload.html");
	}
}