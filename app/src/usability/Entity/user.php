<?php 

namespace src\usability\Entity;

class user
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
	 * @prob('name' = first_name)
	 * @prob('type' = varchar)
	 * @prob('length' = 255)
	 */
	private $first_name;

	/**
	 * @var string
	 * @prob('name' = last_name)
	 * @prob('type' = varchar)
	 * @prob('length' = 255)
	 */
	private $last_name;

	/**
	 * @var string
	 * @prob('name' = email)
	 * @prob('type' = varchar)
	 * @prob('length' = 255)
	 */
	private $email;

	/**
	 * @var string
	 * @prob('name' = password)
	 * @prob('type' = varchar)
	 * @prob('length' = 255)
	 */
	private $password;

	/**
	 * Set id
	 *
	 * @param string $id
	 * @return user
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
	 * Set first_name
	 *
	 * @param string $first_name
	 * @return user
	 */
	public function setFirst_name($first_name)
	{
		$this->first_name = $first_name;

		return $this;
	}

	/**
	 * Get first_name
	 *
	 * @return string
	 */
	public function getFirst_name()
	{
		return $this->first_name;
	}

	/**
	 * Set last_name
	 *
	 * @param string $last_name
	 * @return user
	 */
	public function setLast_name($last_name)
	{
		$this->last_name = $last_name;

		return $this;
	}

	/**
	 * Get last_name
	 *
	 * @return string
	 */
	public function getLast_name()
	{
		return $this->last_name;
	}

	/**
	 * Set email
	 *
	 * @param string $email
	 * @return user
	 */
	public function setEmail($email)
	{
		$this->email = $email;

		return $this;
	}

	/**
	 * Get email
	 *
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * Set password
	 *
	 * @param string $password
	 * @return user
	 */
	public function setPassword($password)
	{
		$this->password = $password;

		return $this;
	}

	/**
	 * Get password
	 *
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}
}