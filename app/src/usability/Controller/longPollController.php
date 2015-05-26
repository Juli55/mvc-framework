<?php 

namespace usability\Controller;

use Kernel\Controller;
use src\usability\Poll\dbPoll;

class longPollController extends Controller
{
	public function longpoll()
	{
		$dbPoll = new dbPoll();
		return $dbPoll->poll();
	}
}