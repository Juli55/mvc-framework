<?php
namespace Tools\Files\Upload;

class FileUpload
{
	/**
	 * @var String
	 */
	private $folder;

	/**
	 * @var Array
	 */
	private $file;

	/**
	 * @var int
	 */
	private $max_size;

	/**
	 * @param String $folder,$max_size
	 * @param Array $file
	 *
	 * @return void
	 */
	public function __construct($folder,$file,$max_size = 2048)
	{
		$this->folder = $folder;
		$this->file = $file;
		$this->max_size = $max_size;
	}

	/**
	 * @return bool
	 */
	public function upload()
	{
		$folder   = $this->folder;
		$file 	  = $this->file;
		$max_size = $this->max_size;

		if(!is_dir($folder)){
			
			mkdir($folder, 0700);
		}
		$folder = rtrim($folder, '/');
		$upload_file = $folder.'/'.basename($file['name']);
		if(move_uploaded_file($file['tmp_name'], $upload_file)){

			return true;

		}else{

			return false;

		}
	}
}