<?php 

namespace usability\Controller;

use Kernel\Controller;
use Kernel\HttpKernel\Request;

class httpController extends Controller
{
	public function view()
	{
		$request = new Request();
		$post = "";
		if($request->post['post']){
			$post = $request->post['post'];
		}
		return $this->render("usability:http.html",
							array(
								'post' => $post
								)
							);
	}
}