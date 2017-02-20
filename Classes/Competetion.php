<?php

class Competetion implements DBClass
{
	private $id,$title,$type,$type_id,$mu_id,$sex;

	/**
	 * Competetion constructor.
	 * @param $id
	 * @param $title
	 * @param $type
	 * @param $type_id
	 * @param $mu_id
	 * @param $sex
	 */
	public function __construct($id, $title, CompTypes $type, $mu_id, $sex)
	{
		$this->id = $id;
		$this->title = $title;
		$this->type = $type;
		$this->mu_id = $mu_id;
		$this->sex = $sex;
	}

	public static function createWithDB(array $data)
	{
		return new Competetion($data[DBData::$competetionsID],
								$data[DBData::$competetionsTitle],
								CompTypes::createWithDB($data),
								$data[DBData::$competetionsMuID],
								$data[DBData::$competetionsSex]);
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
	public function getTitle()
	{
		return $this->title;
	}

	/**
	 * @return CompTypes
	 */
	public function getType()
	{
		return $this->type;
	}

	/**
	 * @return mixed
	 */
	public function getTypeId()
	{
		return $this->type_id;
	}

	/**
	 * @return mixed
	 */
	public function getMuId()
	{
		return $this->mu_id;
	}

	/**
	 * @return mixed
	 */
	public function getSex()
	{
		return $this->sex;
	}


}