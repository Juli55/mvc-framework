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
	 * @var array
	 */
	private $whiteList;

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
	public function __construct($folder, $file, $fileExtensions = array(), $mimeTypes = array(), $useFieldTypes = array(), $maxSize = 2048)
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
				//fieldTypes
					if(!empty($fieldTypes)){
						foreach($useFieldTypes as $useFieldType){
							if(array_key_exists($fieldTypes, $useFieldType)){
								$whiteList[] = $fieldTypes[$useFieldType];
							}
						}
					}
				//fileExtension
					if(!empty($fileExtensions)){
						foreach($fileExtensions as $fileExtension){
							foreach($fieldTypes as $key => $value){
								if(array_key_exists($fileExtension, $value)){
									if(array_key_exists($key, $whiteList)){
										$whiteList[] = $value[$fileExtension];
									}
								}
							}
						}
					}
				//mimeTypes
					if(!empty($mimeTypes)){
						foreach($mimeTypes as $mimeType){
							foreach($fieldTypes as $value){
								if(in_array($mimeType, $value)){
									if(array_key_exists($key, $whiteList)){
										$whiteList[] = array_search($mimeType, $value); 
									}
								}
							}
						}
					}
				//set gloabal
					$this->whiteList = $whiteList;
	}

	/**
	 *
	 * The uploadMethod uploads a File 
	 *
	 * @return boolean
	 */
	public function upload()
	{
		$folder    = $this->folder;
		$file 	   = $this->file;
		$maxSize   = $this->maxSize;
		$whiteList = $this->whiteList;
		//read mimeTypes
			$mimeTypeServer  = '';
			$mimeTypeBrowser = '';
		foreach($whiteList as $key => $value){
			//
		}
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
				echo $file['error'];
				return false;
			}
	}
}