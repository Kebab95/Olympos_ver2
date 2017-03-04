<?php
class Main
{
	private $id,$name,$email,$password,$telefon,$type,$bdate,$sex;

	/**
	 * @return mixed
	 */
	public function getSex()
	{
		return ($this->sex?"Férfi":"Nő");
	}
	public function getSexFlag(){
		return$this->sex;
	}

	/**
	 * @param mixed $sex
	 */
	public function setSex($sex)
	{
		$this->sex = $sex;
	}


	/**
	 * @return mixed
	 */
	public function getAge()
	{

		$from = new DateTime($this->bdate);
		$to   = new DateTime('today');
		return $from->diff($to)->y;;
	}

	/**
	 * @param mixed $bdate
	 */
	public function setBdate($bdate)
	{
		$this->bdate = $bdate;
	}

	/**
	 * @return mixed
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @param mixed $type
	 */
	public function setType($type)
	{
		$this->type = $type;
	}

	/**
	 * @param mixed $id
	 */
	protected function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * @param mixed $name
	 */
	protected function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @param mixed $email
	 */
	protected function setEmail($email)
	{
		$this->email = $email;
	}

	/**
	 * @param mixed $password
	 */
	protected function setPassword($password)
	{
		$this->password = $password;
	}

	/**
	 * @param mixed $telefon
	 */
	protected function setTelefon($telefon)
	{
		$this->telefon = $telefon;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @return mixed
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @return mixed
	 */
	public function getTelefon()
	{
		return $this->telefon;
	}
}
class UserPermissions extends Main{
	private $admin=false;
	private $moderator =false;
	private $visitor = false;
	private $federationLeader = false;
	private $clubLeader = false;
	private $judge = false;
	private $trainer = false;
	private $member = false;

	public function isAdmin(){
		return $this->admin;
	}
	public function setAdmin($boolean){
		$this->admin =$boolean;
	}
	/**
	 * @return boolean
	 */
	public function isModerator()
	{
		return $this->moderator;
	}

	/**
	 * @param boolean $moderator
	 */
	public function setModerator($moderator)
	{
		$this->moderator = $moderator;
	}

	/**
	 * @return boolean
	 */
	public function isVisitor()
	{
		return $this->visitor;
	}

	/**
	 * @param boolean $visitor
	 */
	public function setVisitor($visitor)
	{
		$this->visitor = $visitor;
	}

	/**
	 * @return boolean
	 */
	public function isFederationLeader()
	{
		return $this->federationLeader;
	}

	/**
	 * @param boolean $federationLeader
	 */
	public function setFederationLeader($federationLeader)
	{
		$this->federationLeader = $federationLeader;
	}

	/**
	 * @return boolean
	 */
	public function isClubLeader()
	{
		return $this->clubLeader;
	}

	/**
	 * @param boolean $clubLeader
	 */
	public function setClubLeader($clubLeader)
	{
		$this->clubLeader = $clubLeader;
	}

	/**
	 * @return boolean
	 */
	public function isJudge()
	{
		return $this->judge;
	}

	/**
	 * @param boolean $judge
	 */
	public function setJudge($judge)
	{
		$this->judge = $judge;
	}

	/**
	 * @return boolean
	 */
	public function isTrainer()
	{
		return $this->trainer;
	}

	/**
	 * @param boolean $trainer
	 */
	public function setTrainer($trainer)
	{
		$this->trainer = $trainer;
	}

	/**
	 * @return boolean
	 */
	public function isMember()
	{
		return $this->member;
	}

	/**
	 * @param boolean $member
	 */
	public function setMember($member)
	{
		$this->member = $member;
	}

}