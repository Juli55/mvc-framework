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
		//set cookie
			$request->setCookie('test', 'testValue', 300);
			$cookie = $request->cookie['test'];
		//destroy cookie
			$request->destroyCookie('test');
		//check if an file was sent
			if(isset($request->files['file'])){
				$fileset = 'true';
			}else{
				$fileset = 'false';
			}
		$server = $request->server;
		//set session
			$request->setSession('test', 'testSessionValue');
			$session = $request->session['test'];
		return $this->render("usability:http.html",
							array(
								'post' 	  => $post,
								'get'  	  => $get,
								'cookie'  => $cookie,
								'fileset' => $fileset,
								'server'  => $server,
								'session' => $session
								)
							);
	}
}