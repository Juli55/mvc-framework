<?php

namespace Tools\Files\Upload;

use Tools\Files\Upload\FileType;

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
	 * @var whitelist
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
	public function __construct($folder,$file, $fileExtensions = array(), $mimeTypes = array(), $usefieldTypes = array(), $maxSize = 2048)
	{
		//setting Upload Information
			$this->folder 	= $folder;
			$this->file 	= $file;
			$this->maxSize 	= $maxSize;
			//setting WhiteList
				$whiteList = array();
				//init FieldTypes
					$FieldType = new FileType;
					$fieldTypes = $FieldType->getFileTypes();
				//fileExtension
					if(!empty($fileExtensions)){
						foreach($fileExtensions => $fileExtension){
							foreach($fieldTypes as $value){
								if(array_key_exists($fileExtension, $value)){
									$whitelist[] = $value[$fileExtension$];
								}
							}
						}
					}
				//mimeTypes
					if(!empty($mimeTypes)){
						foreach($mimeTypes => $mimeType){
							foreach($fieldTypes as $value){
								if(in_array($mimeType, $value)){
									$whitelist[] = array_search($mimeType, $value); 
								}
							}
						}
					}
				//fieldTypes
					if(!empty($fieldTypes)){
						foreach($useFieldTypes as $useFieldType){
							if(array_key_exists($fieldTypes, $useFieldType)){
								$whitelist[] = $fieldTypes[$useFieldType];
							}
						}
					}
				//set gloabal
					$this->whitelist($whitelist);
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