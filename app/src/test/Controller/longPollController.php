<?php
namespace test\Controller;

use Kernel\Controller;
use Kernel\EntityManager\EntityManager;
use Kernel\HttpKernel\Request;
use src\test\Poll\dbPoll;

/**
 * @author Julian Bertsch <julian.bertsch42@gmail.de>
 */
class longPollController extends Controller
{
	/**
	 * @return View 
	 */
	public function longpoll()
	{
		$dbPoll = new dbPoll();
		$request = new Request();
		return $dbPoll->poll();
	}
}