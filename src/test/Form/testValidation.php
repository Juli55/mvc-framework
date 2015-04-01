<?php

namespace src\test\Form;

use src\test\Validator\emailValidator;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class testValidation
{
	/**
	 * @return array
	 */
	public function testValidate($values)
	{
		//init validationArray
			$validationArray = array();
		//init Validators
			$emailValidator = new emailValidator;
		//assign Validators
			$validators = array(
								'email' => $emailValidator
								);
		//validate
			foreach($values as $key => $value){
				if(array_key_exists($key, $validators)){
					$validationArray[$key] = $validators[$key]->validate($value);
				}
			}
		$validationArray['password'] = array(
										'errorMsg' => 'falsch',
										'valid'    => true
										);
		return $validationArray;
	}
}