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

	public function getCurrentTimeDefault()
	{
		$dateTime = new \DateTime('now', new \DateTimeZone($this->defaultTimezone));
		return $dateTime->format('d.m.Y H:i:s');
	}

	public function getCurrentTimeSpecific($timezone)
	{
		$dateTime = new \DateTime('now', new \DateTimeZone($timezone));
		return $dateTime->format('d.m.Y H:i:s');
	}

	public function getTimeDefault($datetime)
	{
		$dateTime = new \DateTime($datetime, new \DateTimeZone($this->defaultTimezone));
		return $dateTime->format('d.m.Y H:i:s');
	}

	public function getTimeSpecific($datetime, $timezone)
	{
		$dateTime = new \DateTime($datetime, new \DateTimeZone($timezone));
		return $dateTime->format('d.m.Y H:i:s');
	}

	public function changeToDefault($timezone, $time)
	{
		$dateTime = new \DateTime($time, new \DateTimeZone($timezone));
		$dtz 	  = new \DateTimeZone($this->defaultTimezone);
		$dateTime->setTimezone($dtz);
		return $dateTime->format();
	}

	public function changeToSpecific($timezone, $time, $format)
	{
		$dateTime = new \DateTime($time, new \DateTimeZone($this->defaultTimezone));
		$dtz = new \DateTimeZone($timezone);
		$dateTime->setTimezone($dtz);
		return $dateTime->format($format);
	}


}