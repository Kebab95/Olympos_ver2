<?php
class CompCategory implements DBClass
{
	private $id,$org_id,$ageMin,$ageMax,$personalGrpTitle;
	private $fed_cost1,$fed_cost2;
	private $non_fed_cost1,$non_fed_cost2;
	private $foreign_cos1,$foreign_cost2;
	private $sex;
	private $sexWoman,$sexMan,$sexMixed,$groupFight;
	private $personalWeightMin,$personalWeightMax;
	private $personalKnowLedgeId;


	/**
	 * CompCategory constructor.
	 * @param $id
	 * @param $org_id
	 * @param $ageMin
	 * @param $ageMax
	 * @param $personalGrpTitle
	 * @param $fed_cost1
	 * @param $fed_cost2
	 * @param $non_fed_cost1
	 * @param $non_fed_cost2
	 * @param $foreign_cos1
	 * @param $foreign_cost2
	 */
	public function __construct($id,
	                            $org_id,
	                            $ageMin,
	                            $ageMax,
	                            $personalGrpTitle,
	                            $fed_cost1,
	                            $fed_cost2,
	                            $non_fed_cost1,
	                            $non_fed_cost2,
	                            $foreign_cos1,
	                            $foreign_cost2,
	                            $sex,
	                            bool $sexWoman,
	                            bool $sexMan,
	                            bool $sexMixed,
	                            bool $groupFight,
	                            $personalWeightMin,
	                            $personalWeightMax,
	                            $personalKnowLedgeId)
	{
		$this->id = $id;
		$this->org_id = $org_id;
		$this->ageMin = $ageMin;
		$this->ageMax = $ageMax;
		$this->personalGrpTitle = $personalGrpTitle;
		$this->fed_cost1 = $fed_cost1;
		$this->fed_cost2 = $fed_cost2;
		$this->non_fed_cost1 = $non_fed_cost1;
		$this->non_fed_cost2 = $non_fed_cost2;
		$this->foreign_cos1 = $foreign_cos1;
		$this->foreign_cost2 = $foreign_cost2;
		$this->sex = $sex;
		$this->sexWoman = $sexWoman;
		$this->sexMan = $sexMan;
		$this->sexMixed = $sexMixed;
		$this->groupFight = $groupFight;
		$this->personalWeightMin = $personalWeightMin;
		$this->personalWeightMax = $personalWeightMax;
		$this->personalKnowLedgeId = $personalKnowLedgeId;
	}

	public static function createWithDB(array $data)
	{
		if(isset($data[DBData::$compCatID])){
			return new self(
					$data[DBData::$compCatID],
					$data[DBData::$compCatOrgID],
					$data[DBData::$ageGrpMin],
					$data[DBData::$ageGrpMax],
					$data[DBData::$personalGrpTitle],
					$data[DBData::$compCatFed_cost1],
					$data[DBData::$compCatFed_cost2],
					$data[DBData::$compCatnonFed_cost1],
					$data[DBData::$compCatnonFed_cost2],
					$data[DBData::$compCatForeign_cost1],
					$data[DBData::$compCatForeign_cost2],
					$data[DBData::$compCatSex],
					($data[DBData::$compCatSexWoman]=="t"),
					($data[DBData::$compCatSexMan]=="t"),
					($data[DBData::$compCatSexMixed]=="t"),
					($data[DBData::$compCatGroupFight]=="t"),
					$data[DBData::$personalGrpWeightMin],
					$data[DBData::$personalGrpWeightMax],
					$data[DBData::$personalGrpknowLEdgeID]);
		}
		else {
			return null;
		}


	}

	function __toString()
	{
		return "Nem: ".$this->getActualSex().", Kor: ".$this->getAgeMin()." - ".$this->getAgeMax().", Csoport: ".$this->getPersonalGrpTitle();
	}


	/**
	 * @return mixed
	 */
	public function getPersonalWeightMin()
	{
		return $this->personalWeightMin;
	}

	/**
	 * @return mixed
	 */
	public function getPersonalWeightMax()
	{
		return $this->personalWeightMax;
	}

	/**
	 * @return mixed
	 */
	public function getPersonalKnowLedgeId()
	{
		return $this->personalKnowLedgeId;
	}

	/**
	 * @return String
	 */
	public function getActualSex(){
		if($this->isSexWoman()){
			return "Férfi";
		}
		else if($this->isSexMan()){
			return "Nő";
		}
		else if($this->isSexMixed()){
			return "Vegyes";
		}
		else{
			return "Nincs nem beállítva";
		}
	}
	/**
	 * @return boolean
	 */
	public function isSexWoman()
	{
		return $this->sexWoman;
	}

	/**
	 * @return boolean
	 */
	public function isSexMan()
	{
		return $this->sexMan;
	}

	/**
	 * @return boolean
	 */
	public function isSexMixed()
	{
		return $this->sexMixed;
	}

	/**
	 * @return boolean
	 */
	public function isGroupFight()
	{
		return $this->groupFight;
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
	public function getOrgId()
	{
		return $this->org_id;
	}

	/**
	 * @return mixed
	 */
	public function getAgeMin()
	{
		return $this->ageMin;
	}

	/**
	 * @return mixed
	 */
	public function getAgeMax()
	{
		return $this->ageMax;
	}

	/**
	 * @return mixed
	 */
	public function getPersonalGrpTitle()
	{
		return $this->personalGrpTitle;
	}

	/**
	 * @return mixed
	 */
	public function getFedCost1()
	{
		return $this->fed_cost1;
	}

	/**
	 * @return mixed
	 */
	public function getFedCost2()
	{
		return $this->fed_cost2;
	}

	/**
	 * @return mixed
	 */
	public function getNonFedCost1()
	{
		return $this->non_fed_cost1;
	}

	/**
	 * @return mixed
	 */
	public function getNonFedCost2()
	{
		return $this->non_fed_cost2;
	}

	/**
	 * @return mixed
	 */
	public function getForeignCos1()
	{
		return $this->foreign_cos1;
	}

	/**
	 * @return mixed
	 */
	public function getForeignCost2()
	{
		return $this->foreign_cost2;
	}

	/**
	 * @return mixed
	 */
	public function getSex()
	{
		return ($this->sex==1?"Férfi":($this->sex==0?"Nő":"Hiba"));
	}


}