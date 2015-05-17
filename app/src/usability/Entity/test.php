<?php 

namespace src\usability\Entity;

class test
{
	/**
	 * @var string
	 * @prob('name' = id)
	 * @prob('type' = int)
	 * @prob('length' = 255)
	 */
	private $id;

	/**
	 * @var string
	 * @prob('name' = test1)
	 * @prob('type' = varchar)
	 * @prob('length' = 255)
	 */
	private $test1;

	/**
	 * Set id
	 *
	 * @param string $id
	 * @return test
	 */
	public function setId($id)
	{
		$this->id = $id;

		return $this;
	}

	/**
	 * Get id
	 *
	 * @return string
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * Set test1
	 *
	 * @param string $test1
	 * @return test
	 */
	public function setTest1($test1)
	{
		$this->test1 = $test1;

		return $this;
	}

	/**
	 * Get test1
	 *
	 * @return string
	 */
	public function getTest1()
	{
		return $this->test1;
	}
}