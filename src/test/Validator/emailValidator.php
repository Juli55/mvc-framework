<?php

namespace src\test\Validator;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class emailValidator
{
	/**
	 * @param $value
	 *
	 * @return array 
	 */
	public function validate($value)
	{
		
		$valid 	   = false;
		$errorMsg  = '';
		if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
		  $errorMsg = "Invalid email format";
		}else{
			$valid = true;
		}
		$validArray = array(
							'valid'   => $valid,
							'errorMsg' => $errorMsg
							);
		return $validArray;
	}
}