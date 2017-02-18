<?php
class SportUser extends User implements DBClass
{
	private $weight,$beltGrades;

	/**
	 * SportUser constructor.
	 * @param $weight
	 * @param $beltGrades
	 */
	public function SportUser($id,$name,$email,$telefon,$password,$type,$bdate,$weight,$beltGrades)
	{
		$this->__construct($id,$name,$email,$telefon,$password,$type,$bdate);
		$this->weight = $weight;
		$this->beltGrades = $beltGrades;
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
				$data[DBData::$memberDataWeight],
				$data[DBData::$beltGradesName]);
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