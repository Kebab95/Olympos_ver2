<?php

class User extends UserPermissions implements DBClass{


	public function __construct($id,$name,$email,$telefon,$password,$type,$bdate)
	{
		$this->setId($id);
		$this->setName($name);
		$this->setEmail($email);
		$this->setTelefon($telefon);
		$this->setPassword($password);
		$this->setType($type);
		$this->setBdate($bdate);
	}

	public static function createWithDB(array $data)
	{
		return new self($data[DBData::$mainUserID],
				$data[DBData::$mainUserName],
				$data[DBData::$emailDataAdd],
				$data[DBData::$telefonDataNum],
				$data[DBData::$mainUserPass],
				$data[DBData::$mainUserType],
				$data[DBData::$mainUserBDate]);
	}
}