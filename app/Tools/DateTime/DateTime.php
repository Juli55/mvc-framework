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

	/**
	 * @var string
	 */
	private $defaultFormat;

	/**
	 *
	 * The constructor function sets defaultProbertys
	 * 
	 * @param string $format, $defaultTimezone
	 *
	 * @return void 
	 */
	public function __construct($format = '', $defaultTimezone = '')
	{
		//set default timezone
			if(empty($defaultTimezone)){
				$this->defaultTimezone = 'Europe/Berlin';
			}else{
				$this->defaultTimezone = $defaultTimezone;
			}
		//set default datetime
			if(empty($format)){
				$this->defaultFormat = 'd.m.Y H:i:s';
			}else{
				$this->defaultFormat = $format;
			}
	}

	/**
	 *
	 * The getCurrentTimeDefault function returns the current datetime with the default timezone
	 * 
	 * @param string $format
	 *
	 * @return string 
	 */
	public function getCurrentTimeDefault($format = '')
	{
		$dateTime = new \DateTime('now', new \DateTimeZone($this->defaultTimezone));
		if(empty($format)){
			$format = $this->defaultFormat;
		}
		return $dateTime->format($format);
	}

	/**
	 *
	 * The getCurrentTimeSpecific function returns the current datetime with the timezone from parameter
	 * 
	 * @param string $timezone, $format
	 *
	 * @return string 
	 */
	public function getCurrentTimeSpecific($timezone, $format = '')
	{
		$dateTime = new \DateTime('now', new \DateTimeZone($timezone));
		if(empty($format)){
			$format = $this->defaultFormat;
		}
		return $dateTime->format($format);
	}

	/**
	 *
	 * The getDateTime function returns the time from parameter with the correct informations
	 * 
	 * @param string $datetime, $timezone, $format
	 *
	 * @return string 
	 */
	public function getDateTime($datetime, $format = '')
	{
		$dateTime = new \DateTime($datetime, new \DateTimeZone($this->defaultTimezone));
		if(empty($format)){
			$format = $this->defaultFormat;
		}
		return $dateTime->format($format);
	}


	/**
	 *
	 * The changeToDefault function changes an specific datetime to the default
	 * 
	 * @param string $datetime, $timezone, $format
	 *
	 * @return string 
	 */
	public function changeToDefault($datetime, $timezone, $format = '')
	{
		$dateTime = new \DateTime($datetime, new \DateTimeZone($timezone));
		$dtz 	  = new \DateTimeZone($this->defaultTimezone);
		$dateTime->setTimezone($dtz);
		if(empty($format)){
			$format = $this->defaultFormat;
		}
		return $dateTime->format($format);
	}

	/**
	 *
	 * The changeToSpecific function changes an default datetime to an specific
	 * 
	 * @param string $datetime, $timezone, $format
	 *
	 * @return string 
	 */
	public function changeToSpecific($datetime, $timezone, $format = '')
	{
		$dateTime = new \DateTime($datetime, new \DateTimeZone($this->defaultTimezone));
		$dtz 	  = new \DateTimeZone($timezone);
		$dateTime->setTimezone($dtz);
		if(empty($format)){
			$format = $this->defaultFormat;
		}
		return $dateTime->format($format);
	}
}