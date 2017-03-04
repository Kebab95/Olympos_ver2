<?php
class Organization extends Main implements DBClass{
	private $shortName,$regNum,$postalAdd,$faxNum,$webSite,$taxNum;
	private $leaderID;

	public function __construct($id,$name,$email,$telefon,$password,$type,$shortName,$regNum,PostalAdd $postalAdd,$faxNum,$website,$taxNum,$leaderID)
	{
		$this->setId($id);
		$this->setName($name);
		$this->setEmail($email);
		$this->setTelefon($telefon);
		$this->setPassword($password);
		$this->setType($type);
		$this->setSex("false");

		$this->shortName = $shortName;
		$this->regNum = $regNum;
		$this->postalAdd = $faxNum;
		$this->webSite = $website;
		$this->taxNum = $taxNum;
		$this->leaderID = $leaderID;
	}
	public static function createWithDB(array $data)
	{

		switch($data[DBData::$mainUserType]){
			case 2: $leaderID=$data[DBData::$fedLeaderMUID]; break;
			case 3: $leaderID=$data[DBData::$clubLeaderMUID]; break;
			default: $leaderID=null;
		}
		return new self($data[DBData::$mainUserID],
				$data[DBData::$mainUserName],
				$data[DBData::$emailDataAdd],
				$data["tel_num"],
				$data[DBData::$mainUserPass],
				$data[DBData::$mainUserType],
				$data[DBData::$orgShortName],
				$data[DBData::$orgRegNum],
				PostalAdd::createWithDB($data),
				$data["fax_num"],
				$data[DBData::$orgWebsite],
				$data[DBData::$orgTaxNum],
				$leaderID);
	}
	/*
	public function __construct(array $var)
	{
		$this->setId($var[DBData::$mainUserID]);
		$this->setName($var[DBData::$mainUserName]);
		$this->setEmail($var[DBData::$emailDataAdd]);
		$this->setTelefon($var["tel_num"]);
		//$this->setPassword($var[DBData::$mainUserPass]);
		$this->setType($var[DBData::$mainUserType]);

		$this->shortName = $var[DBData::$orgShortName];
		$this->regNum = $var[DBData::$orgRegNum];
		$this->postalAdd = new PostalAdd(
			DBData::$postalAddPCode,
			DBData::$postalAddTown,
			DBData::$postalAddStreet
		);
		$this->faxNum = $var["fax_num"];
		$this->webSite = $var[DBData::$orgWebsite];
		$this->taxNum = $var[DBData::$orgTaxNum];
		switch($this->getType()){
			case 2: $this->leaderID=$var[DBData::$fedLeaderMUID]; break;
			case 3: $this->leaderID=$var[DBData::$clubLeaderMUID]; break;
			default: $this->leaderID=null;
		}
	}
	*/


	/**
	 * @return null
	 */
	public function getLeaderID()
	{
		return $this->leaderID;
	}

	/**
	 * @param null $leaderID
	 */
	public function setLeaderID($leaderID)
	{
		$this->leaderID = $leaderID;
	}
	/**
	 * @return mixed
	 */
	public function getShortName()
	{
		return $this->shortName;
	}

	/**
	 * @param mixed $shortName
	 */
	public function setShortName($shortName)
	{
		$this->shortName = $shortName;
	}

	/**
	 * @return mixed
	 */
	public function getRegNum()
	{
		return $this->regNum;
	}

	/**
	 * @param mixed $regNum
	 */
	public function setRegNum($regNum)
	{
		$this->regNum = $regNum;
	}

	/**
	 * @return PostalAdd
	 */
	public function getPostalAdd()
	{
		return $this->postalAdd;
	}

	/**
	 * @param PostalAdd $postalAdd
	 */
	public function setPostalAdd($postalAdd)
	{
		$this->postalAdd = $postalAdd;
	}

	/**
	 * @return mixed
	 */
	public function getFaxNum()
	{
		return $this->faxNum;
	}

	/**
	 * @param mixed $faxNum
	 */
	public function setFaxNum($faxNum)
	{
		$this->faxNum = $faxNum;
	}

	/**
	 * @return mixed
	 */
	public function getWebSite()
	{
		return $this->webSite;
	}

	/**
	 * @param mixed $webSite
	 */
	public function setWebSite($webSite)
	{
		$this->webSite = $webSite;
	}

	/**
	 * @return mixed
	 */
	public function getTaxNum()
	{
		return $this->taxNum;
	}

	/**
	 * @param mixed $taxNum
	 */
	public function setTaxNum($taxNum)
	{
		$this->taxNum = $taxNum;
	}



}