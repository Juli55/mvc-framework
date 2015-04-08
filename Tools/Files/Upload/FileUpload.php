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
							if(array_key_exists($useFieldType, $fieldTypes)){
								$whiteList[$useFieldType] = $fieldTypes[$useFieldType];
							}
						}
					}
				//fileExtension
					if(!empty($fileExtensions)){
						foreach($fileExtensions as $fileExtension){
							foreach($fieldTypes as $key => $value){
								if(array_key_exists($fileExtension, $value)){
									if(!array_key_exists($key, $whiteList)){
										$whiteList[$fileExtension] = $value[$fileExtension];
									}
								}
							}
						}
					}
				//mimeTypes
					if(!empty($mimeTypes)){
						foreach($mimeTypes as $mimeType){
							foreach($fieldTypes as $key => $value){
								if(in_array($mimeType, $value)){
									if(!array_key_exists($key, $whiteList)){
										$whiteList[array_search($mimeType, $value)] = $mimeType; 
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
		$folder    			 = $this->folder;
		$file 	   			 = $this->file;
		$uploadFileSize      = $file['size'] /1000;
		$maxSize   			 = $this->maxSize;
		$whiteList 			 = $this->whiteList;
		$uploadFileExtension = $file['name'];
		$fileExtensionValid	 = false;
		$mimeTypeValid		 = false;
		$fileSizeValid		 = false;
		$finfo 				 = new \finfo(FILEINFO_MIME_TYPE);
		//read mimeTypes
			$mimeTypeServer  = $finfo->file($file['tmp_name']);
			$mimeTypeClient  = $file['type'];

		//validate FileSize
			if($uploadFileSize <= $maxSize){
				$fileSizeValid = true;
			}
		if($fileSizeValid){
			foreach($whiteList as $key => $value){
				if(is_array($value)){
					foreach($value as $fileExtension => $mimeType){
						$fileExtension = '.'.$fileExtension;
						//check fileExtension
							if(preg_match("/$fileExtension\$/i", $uploadFileExtension)){
								$fileExtensionValid = true;
							}
						//check mimeType
							if($mimeType === $mimeTypeClient && $mimeType === $mimeTypeServer){
								$mimeTypeValid = true;
							}
					}
				}else{
					$fileExtension = $key;
					$mimeType 	   = $value;
					$fileExtension = '.'.$fileExtension;
					//check fileExtension
						if(preg_match("/$fileExtension\$/i", $uploadFileExtension)){
							$fileExtensionValid = true;
						}
					//check mimeType
						if($value === $mimeTypeClient && $value === $mimeTypeServer){
							$mimeTypeValid = true;
						}
				}
			}
		}
		if($fileExtensionValid && $mimeTypeValid && $fileSizeValid){
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
		return false;
	}
}