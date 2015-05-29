<?php

namespace Tools\DateTime;

/**
 * @author Julian Bertsch <Julian.Bertsch42@gmail.com>
 */
class DateTime
{
	/**
	 * @var string
	 */
	private $defaultTimezone;

	public function __construct($defaultTimezone = '')
	{
		if(empty($defaultTimezone)){
			$this->defaultTimezone = 'Europe/Berlin';
		}else{
			$this->defaultTimezone = $defaultTimezone;
		}
	}

	/**
	 *
	 * The getCurrentTimeDefault function returns the current datetime with the default timezone
	 * 
	 * @param 
	 *
	 * @return string 
	 */
	public function getCurrentTimeDefault()
	{
		$dateTime = new \DateTime('now', new \DateTimeZone($this->defaultTimezone));
		return $dateTime->format('d.m.Y H:i:s');
	}

	/**
	 *
	 * The getCurrentTimeSpecific function returns the current datetime with the timezone from parameter
	 * 
	 * @param 
	 *
	 * @return string 
	 */
	public function getCurrentTimeSpecific($timezone)
	{
		$dateTime = new \DateTime('now', new \DateTimeZone($timezone));
		return $dateTime->format('d.m.Y H:i:s');
	}

	/**
	 *
	 * The getTimeDefault function returns the time from parameter and returns the time with default timezone
	 * 
	 * @param string $datetime
	 *
	 * @return string 
	 */
	public function getTimeDefault($datetime)
	{
		$dateTime = new \DateTime($datetime, new \DateTimeZone($this->defaultTimezone));
		return $dateTime->format('d.m.Y H:i:s');
	}

	/**
	 *
	 * The getTimeSpecific function returns the time from parameter and returns the time with specific timezone
	 * 
	 * @param string $datetime, $timezone
	 *
	 * @return string 
	 */
	public function getTimeSpecific($datetime, $timezone)
	{
		$dateTime = new \DateTime($datetime, new \DateTimeZone($timezone));
		return $dateTime->format('d.m.Y H:i:s');
	}

	/**
	 *
	 * The changeToDefault function changes an specific datetime to the default
	 * 
	 * @param string $datetime, $timezone
	 *
	 * @return string 
	 */
	public function changeToDefault($datetime, $timezone)
	{
		$dateTime = new \DateTime($datetime, new \DateTimeZone($timezone));
		$dtz 	  = new \DateTimeZone($this->defaultTimezone);
		$dateTime->setTimezone($dtz);
		return $dateTime->format();
	}

	/**
	 *
	 * The changeToSpecific function changes an default datetime to an specific
	 * 
	 * @param string $datetime, $timezone
	 *
	 * @return string 
	 */
	public function changeToSpecific($datetime, $timezone, $format)
	{
		$dateTime = new \DateTime($time, new \DateTimeZone($this->defaultTimezone));
		$dtz = new \DateTimeZone($timezone);
		$dateTime->setTimezone($dtz);
		return $dateTime->format($format);
	}


}