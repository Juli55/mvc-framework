<?php 

namespace usability\Controller;

use Kernel\Controller;

class JsonResponseController extends Controller
{
	public function view()
	{
		return $this->JsonResponse(
									array('key' => 'value')
									);
	}
}