<?php
namespace test\Controller;

use Kernel\Controller;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class scrollBottomController extends Controller
{
	/**
	 * @return View 
	 */
	public function view()
	{
		echo "hey";
		return $this->render("test:scrollBottom.html");
	}
}