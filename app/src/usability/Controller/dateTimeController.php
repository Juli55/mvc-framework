<?php 

namespace usability\Controller;

use Kernel\Controller;
use Tools\DateTime\DateTime;

class dateTimeController extends Controller
{
	public function view()
	{
		$DateTime = new DateTime();
		echo "<p>".$DateTime->getCurrentTime('Europe/Berlin')."</p>";
		return $this->render("usability:block.html");
	}
}