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
		$get  = "";
		if($request->post['post']){
			$post = $request->post['post'];
		}
		if($request->get['get']){
			$get = $request->get['get'];
		}
		return $this->render("usability:http.html",
							array(
								'post' => $post,
								'get'  => $get
								)
							);
	}
}