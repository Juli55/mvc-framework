<?php

namespace Tools\Authentification;

use Kernel\EntityManger\EntityManger;
use Kernel\HttpKernel\Request;

/**
 * @author Dennis Eisele <dennis.eisele@online.de>
 */

class LoginScript{

	public function login($identificator,$password_key)
	{
		$em = new EntityManger;
		$request = new Request

		$db = $em->getConnection();
		$entity = $em->getEntity("profile:user");

		$identificator_value = $request->Post[$identificator];
		$password= $request->Post[$password_key]);
		
		$salt_1 = "74930slei93kdie9i3kdie93kdie9kdie93kdie93kdie93kdie9kei309ioögeut3fhsoöiutusü0emiß+m0gü8wvtpomuv,ß+,xiü.uim vüiri3mß";
		$salt_2 = "dsajkflsafis543908530ljfksld4sdf34453ß0klsdjflkdslkjflksjflkdsjflkjdslkfjdslkfjlkdsjflkdsjfldsjlfdslkflsdjflkdsjlfdslkjfldskjflkjdslfjdslklsl";
		$password  = hash('sha512', $salt_1.$password.$salt_2);

		if(isset($identificator_value) && isset($password)
		{
			$em->find($identificator,$identificator_value);

			if(!empty($entity->call_user_func(array($entity,'get'.ucfirst($identificator)); && $entity->getPassword() === $password)
			{
				$request->setSession('userid',$entity->getID());
			}
		}
		else
		{
			return false;
		}

	}
	
}