<?php 

namespace src\test\Entity;

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
}