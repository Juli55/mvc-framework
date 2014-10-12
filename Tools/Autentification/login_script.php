<?php

namespace Tools\Authentification;

use Kernel\EntityManger\EntityManger;
use Kernel\HttpKernel\Request;

/**
 * @author Dennis Eisele <dennis.eisele@online.de>
 */

class login_script{

	public function login()
	{
		$em = new EntityManger;
		$request = new Request

		$db = $em->getConnection();
		$entity = $em->getEntity("profile:user");

		$email = $request->Post['email'];
		$password= $request->Post['password']);
		
		$salt_1 = "74930slei93kdie9i3kdie93kdie9kdie93kdie93kdie93kdie9kei309ioögeut3fhsoöiutusü0emiß+m0gü8wvtpomuv,ß+,xiü.uim vüiri3mß";
		$salt_2 = "dsajkflsafis543908530ljfksld4sdf34453ß0klsdjflkdslkjflksjflkdsjflkjdslkfjdslkfjlkdsjflkdsjfldsjlfdslkflsdjflkdsjlfdslkjfldskjflkjdslfjdslklsl";
		$password  = hash('sha512', $salt_1.$password.$salt_2);

		if(isset($userid) && isset($password)
		{
			$em->find('email',$email);

			if(!empty($entity->getEmail() && ($entity->getPassword() === $password)
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