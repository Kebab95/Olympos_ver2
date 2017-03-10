<?php
class SportUser extends User implements DBClass
{
	private $weight,$beltGrades;
	private $knowLedgeId;

	/**
	 * SportUser constructor.
	 * @param $weight
	 * @param $beltGrades
	 */
	public function SportUser($id,$name,$email,$telefon,$password,$type,$bdate,$sex,$weight,$beltGrades,$knowLedgeId)
	{
		$this->__construct($id,$name,$email,$telefon,$password,$type,$bdate,$sex);
		$this->weight = $weight;
		$this->beltGrades = $beltGrades;
		$this->knowLedgeId = $knowLedgeId;
	}

	public static function createWithDB(array $data)
	{
		return new self($data[DBData::$mainUserID],
				$data[DBData::$mainUserName],
				$data[DBData::$emailDataAdd],
				$data[DBData::$telefonDataNum],
				$data[DBData::$mainUserPass],
				$data[DBData::$mainUserType],
				$data[DBData::$mainUserBDate],
				$data[DBData::$mainUserSex]=="t",
				$data[DBData::$memberDataWeight],
				$data[DBData::$beltGradesName],
				$data[DBData::$beltGradesLevelId]);
	}
	public static function isSportUser($SportUser){
		return $SportUser instanceof SportUser;
	}

	/**
	 * @return mixed
	 */
	public function getKnowLedgeId()
	{
		return $this->knowLedgeId;
	}
	public function getKnowLedgeId_toString(){
		switch($this->knowLedgeId){
			case 1: return "Kezdő";
			case 2: return "Haladó";
			case 3: return "Mester";
			default: return "Hiba";
		}
	}

	public function getWeight_toString(){
		return $this->getWeight()." Kg";
	}
	/**
	 * @return mixed
	 */
	public function getWeight()
	{
		return $this->weight;
	}

	/**
	 * @return mixed
	 */
	public function getBeltGrades()
	{
		return $this->beltGrades;
	}



}