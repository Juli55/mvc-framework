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
	 * @var Object
	 */
	public $userObject;

	/**
	 * @var int
	 */
	public $errorNumber;


	/**
	 * @return boolean
	 */
	public function login()
	{
		$request = new Request;
		$em = new EntityManager;

		//initalize the securityConfig
		securityConfig::init();

		$securityConfig = securityConfig::getSecurityConfig();

		$identificator  = $securityConfig['identificator'];
		$passwordKey    = $securityConfig['passwordKey'];
		$entityShortcut = $securityConfig['entityShortcut'];

		$em->getConnection();
		$entity = $em->getEntity($entityShortcut);

		if(empty($request->Session['userid'])){

			if(isset($request->Post[$identificator]) && isset($request->Post[$passwordKey])) {
				$identificatorValue = $request->Post[$identificator];
				$password= $request->Post[$passwordKey];
				
				$salt_1 = "74930slei93kdie9i3kdie93kdie9kdie93kdie93kdie93kdie9kei309ioögeut3fhsoöiutusü0emiß+m0gü8wvtpomuv,ß+,xiü.uim vüiri3mß";
				$salt_2 = "dsajkflsafis543908530ljfksld4sdf34453ß0klsdjflkdslkjflksjflkdsjflkjdslkfjdslkfjlkdsjflkdsjfldsjlfdslkflsdjflkdsjlfdslkjfldskjflkjdslfjdslklsl";
				$password  = hash('sha512', $salt_1.$password.$salt_2);

				$em->find($identificator,$identificatorValue);

				$identificatorValue = call_user_func(array($entity,'get'.ucfirst($identificator)));

				if(!empty($identificatorValue) && $entity->getPassword() === $password){

					$this->userObject = $entity;
					$request->setSession('userid',$entity->getID());
					return true;
				}
				else{
					return 2;
				} 
			}
			else{
				return 3;
			}
		}else{
			
			$this->userObject = $entity;
			$em->find('id',$request->Session['userid']);
			return true;
		}

		return false;
	}
}