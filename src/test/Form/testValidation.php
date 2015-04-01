<?php

namespace src\test\Form;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class testValidation
{
	/**
	 * @return View 
	 */
	public function testValidate()
	{
		
		$validation = array();
		$validation['email'] = array(
									'errorMsg' => 'das',
									'valid'    => false
									);
		$validation['password'] = array(
										'errorMsg' => 'falsch',
										'valid'    => true
										);
		return $validation;
	}
}