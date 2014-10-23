<?php

namespace Tools\Authentification;

use Kernel\HttpKernel\Request;
use Kernel\EntityManager\EntityManager;

/**
 * @author Dennis Eisele <dennis.eisele@online.de>
 */

class LoginScript{

	public function login($identificator,$password_key)
	{
		$request = new Request;
		$em = new EntityManager;

		$em->getConnection();
		$entity = $em->getEntity("profile:user");

		if(isset($request->Post[$identificator]) && isset($request->Post[$password_key])) {
			$identificatorValue = $request->Post[$identificator];
			$password= $request->Post[$password_key];
			
			$salt_1 = "74930slei93kdie9i3kdie93kdie9kdie93kdie93kdie93kdie9kei309ioögeut3fhsoöiutusü0emiß+m0gü8wvtpomuv,ß+,xiü.uim vüiri3mß";
			$salt_2 = "dsajkflsafis543908530ljfksld4sdf34453ß0klsdjflkdslkjflksjflkdsjflkjdslkfjdslkfjlkdsjflkdsjfldsjlfdslkflsdjflkdsjlfdslkjfldskjflkjdslfjdslklsl";
			$password  = hash('sha512', $salt_1.$password.$salt_2);

			$em->find($identificator,$identificatorValue);

			$identificatorValue = call_user_func(array($entity,'get'.ucfirst($identificator)));

			if(!empty($identificatorValue) && $entity->getPassword() === $password){

				$request->setSession('userid',$entity->getID());
			}
			
		}else{

			return false;
		}

	}
	
}