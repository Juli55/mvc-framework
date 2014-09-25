<?php 


 /**
  * @author Julian Bertsch <julian.bertsch42@gmail.de>
  */
class user
{
	/**
	 * @var int
	 */
	private $ID;

	/**
	 * @var string
	 */
	private $first_name;

	/**
	 * @var string
	 */
	private $last_name;

	/**
	 * @var string
	 */
	private $email;

	/**
	 * @var string
	 */
	private $password;

	/**
	 * @var Date
	 */
	private $birthday;

	/**
	 * @var integer
	 */
	private $gender;

	/**
	 * @var string
	 */
	private $about_me;

	/**
	 * @var string
	 */
	private $focusing;

	/**
	 * @var integer
	 */
	private $img_id;

	/**
     * Get ID
     * @param integer $ID
     * @return integer 
     */
	public function setID($ID)
	{
		$this->ID = $ID;

		return $this;
	}

	/**
     * Get ID
     *
     * @return integer 
     */
	public function getID()
	{
		return $this->ID;
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
     * @return Date 
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
     * @return int 
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
     * Get string
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
     * @return int 
     */
	public function getImg_id()
	{
		return $this->img_id;
	}
}