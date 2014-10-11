<?php
namespace Tools\Folder;

/**
 * @author Julian Bertsch <Julian.bertch42@gmail.com>
 */
class Folder
{

	public static function delete($dirPath)
	{
	    if (! is_dir($dirPath)) {
	        throw new InvalidArgumentException("$dirPath must be a directory");
	    }
	    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
	        $dirPath .= '/';
	    }
	    $files = glob($dirPath . '*', GLOB_MARK);
	    foreach ($files as $file) {
	        if (is_dir($file)) {
	            self::delete($file);
	        } else {
	            unlink($file);
	        }
	    }
	    rmdir($dirPath);
	}
}