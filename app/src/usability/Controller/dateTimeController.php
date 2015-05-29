<?php 

namespace usability\Controller;

use Kernel\Controller;
use Tools\DateTime\DateTime;

class dateTimeController extends Controller
{
	public function view()
	{
		$DateTime = new DateTime();
		$currentTimeDefault = $DateTime->getCurrentTimeDefault()."</p>";
		$currentTimeSpecific = $DateTime->getCurrentTimeSpecific('Europe/London')."</p>";
		$getDateTime 		 = $DateTime->getDateTime('2012-07-08 11:14:15.638276', 'd-m-Y H:i:s')."</p>";
		$changeToDefault 	 = $DateTime->changeToDefault('2012-07-08 11:14:15.638276', 'Europe/London')."</p>";
		$changeToSpecific 	 = $DateTime->changeToSpecific('2012-07-08 11:14:15.638276', 'Europe/London')."</p>";
		return $this->render("usability:datetime.html",
							array(
								'currentTimeDefault' => $currentTimeDefault,
								'currentTimeSpecific' => $currentTimeSpecific,
								'getDateTime' => $getDateTime,
								'changeToDefault' => $changeToDefault,
								'changeToSpecific' => $changeToSpecific,
								)
							);
	}
}