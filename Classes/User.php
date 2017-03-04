<?php

class User extends UserPermissions implements DBClass{


	public function __construct($id,$name,$email,$telefon,$password,$type,$bdate,bool $sex)
	{
		$this->setId($id);
		$this->setName($name);
		$this->setEmail($email);
		$this->setTelefon($telefon);
		$this->setPassword($password);
		$this->setType($type);
		$this->setBdate($bdate);
		$this->setSex($sex);
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
				$data[DBData::$mainUserSex]=="t");
	}
	public static function isUser($User){
		return $User instanceof User;
	}
}