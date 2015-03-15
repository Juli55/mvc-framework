<?php 

namespace test\Entity;

class User
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
	 * @var string
	 * @prob('name' = birthday)
	 * @prob('type' = varchar)
	 * @prob('length' = 255)
	 */
	private $birthday;

	/**
	 * @var string
	 * @prob('name' = gender)
	 * @prob('type' = varchar)
	 * @prob('length' = 255)
	 */
	private $gender;

	/**
	 * @var string
	 * @prob('name' = about_me)
	 * @prob('type' = varchar)
	 * @prob('length' = 255)
	 */
	private $about_me;

	/**
	 * @var string
	 * @prob('name' = focusing)
	 * @prob('type' = varchar)
	 * @prob('length' = 255)
	 */
	private $focusing;

	/**
	 * @var string
	 * @prob('name' = img_id)
	 * @prob('type' = varchar)
	 * @prob('length' = 255)
	 */
	private $img_id;

	/**
	 * Set id
	 *
	 * @param string $id
	 * @return User
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
	 * @return User
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
	 * @return User
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
	 * @return User
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
	 * @return User
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

	/**
	 * Set birthday
	 *
	 * @param string $birthday
	 * @return User
	 */
	public function setBirthday($birthday)
	{
		$this->birthday = $birthday;

		return $this;
	}

	/**
	 * Get birthday
	 *
	 * @return string
	 */
	public function getBirthday()
	{
		return $this->birthday;
	}

	/**
	 * Set gender
	 *
	 * @param string $gender
	 * @return User
	 */
	public function setGender($gender)
	{
		$this->gender = $gender;

		return $this;
	}

	/**
	 * Get gender
	 *
	 * @return string
	 */
	public function getGender()
	{
		return $this->gender;
	}

	/**
	 * Set about_me
	 *
	 * @param string $about_me
	 * @return User
	 */
	public function setAbout_me($about_me)
	{
		$this->about_me = $about_me;

		return $this;
	}

	/**
	 * Get about_me
	 *
	 * @return string
	 */
	public function getAbout_me()
	{
		return $this->about_me;
	}

	/**
	 * Set focusing
	 *
	 * @param string $focusing
	 * @return User
	 */
	public function setFocusing($focusing)
	{
		$this->focusing = $focusing;

		return $this;
	}

	/**
	 * Get focusing
	 *
	 * @return string
	 */
	public function getFocusing()
	{
		return $this->focusing;
	}

	/**
	 * Set img_id
	 *
	 * @param string $img_id
	 * @return User
	 */
	public function setImg_id($img_id)
	{
		$this->img_id = $img_id;

		return $this;
	}

	/**
	 * Get img_id
	 *
	 * @return string
	 */
	public function getImg_id()
	{
		return $this->img_id;
	}
}