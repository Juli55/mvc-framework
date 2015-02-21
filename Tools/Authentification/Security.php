<?php

namespace Tools\Authentification;

use Kernel\HttpKernel\Request;
use Kernel\EntityManager\EntityManager;
use Config\securityConfig;

/**
 * @author Dennis Eisele  <dennis.eisele@online.de>
 * @author Julian Bertsch <Julian.bertsch42@gmail.de>
 */

class Security{

	/**
	 * @var object
	 */
	public $userObject;

	/**
	 * @var int
	 */
	public $errorNumber;

	/**
	 *
	 * The loginMethod check if logged or login when the datas are right
	 * 
	 * @return boolean
	 */
	public function login()
	{
		$request = new Request;
		$em 	 = new EntityManager;
		//initalize the securityConfig
			securityConfig::init();
			$securityConfig = securityConfig::getSecurityConfig();
			$identificator  = $securityConfig['identificator'];
			$passwordKey    = $securityConfig['passwordKey'];
			$entityShortcut = $securityConfig['entityShortcut'];
		//get the dbConnection
			$em->getConnection();
			$entity = $em->getEntity($entityShortcut);
		//if the authentificationSession is empty then check then loginRequest
			if(empty($request->session['userid'])){
				//check if the authentificationPostParameters aren't empty then check if the datas are valid then return
				if(!empty($request->post[$identificator]) && !empty($request->post[$passwordKey])){
					//set the identificatorValue and the passwordValue
						$identificatorValue = $request->post[$identificator];
						$passwordValue		= $request->post[$passwordKey];
					//salt and hash the password
						$salt1 = "74930slei93kdie9i3kdie93kdie9kdie93kdie93kdie93kdie9kei309ioögeut3fhsoöiutusü0emiß+m0gü8wvtpomuv,ß+,xiü.uim vüiri3mß";
						$salt2 = "dsajkflsafis543908530ljfksld4sdf34453ß0klsdjflkdslkjflksjflkdsjflkjdslkfjdslkfjlkdsjflkdsjfldsjlfdslkflsdjflkdsjlfdslkjfldskjflkjdslfjdslklsl";
						$password  = hash('sha512', $salt1.$passwordValue.$salt2);
					//get identificatorValue
						$em->find($identificator,$identificatorValue);
						$identificatorValue = call_user_func(array($entity,'get'.ucfirst($identificator)));
					//if identificatorValue isn't empty and if the password is right return true else set an error number
						if(!empty($identificatorValue) && $entity->getPassword() === $password){

							$this->userObject = $entity;
							$request->setSession('userid',$entity->getID());
							return true;
						}else{
							$this->errorNumber = 1;
						} 
				}else{
					$this->errorNumber = 2;
				}
			}else{
				//set the userObject
					$this->userObject = $entity;
					$em->find('id',$request->session['userid']);
				return true;
			}
		return false;
	}
}