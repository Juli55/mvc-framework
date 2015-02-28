<?php

namespace Tools\Files\Upload;

class FileUpload
{
	/**
	 * @var string
	 */
	private $folder;

	/**
	 * @var array
	 */
	private $file;

	/**
	 * @var int
	 */
	private $maxSize;

	/**
	 *
	 * @param string $folder,$maxSize
	 * @param array $file
	 *
	 * @return void
	 */
	public function __construct($folder,$file,$maxSize = 2048)
	{
		$this->folder 	= $folder;
		$this->file 	= $file;
		$this->maxSize 	= $maxSize;
	}

	/**
	 *
	 * The uploadMethod uploads a File 
	 *
	 * @return boolean
	 */
	public function upload()
	{
		$folder   = $this->folder;
		$file 	  = $this->file;
		$maxSize  = $this->maxSize;
		//if the folder doesn't exist then create it
			if(!is_dir($folder)){			
				mkdir($folder, 0700);
			}
		//upload file and return boolean to check if it has done or not
			$folder 	= rtrim($folder, '/');
			$uploadFile = $folder.'/'.basename($file['name']);
			if(move_uploaded_file($file['tmp_name'], $uploadFile)){
				return true;
			}else{
				return false;
			}
	}
}