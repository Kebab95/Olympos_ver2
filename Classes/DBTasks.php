<?php
class DBTasks extends Database
{
	public function __construct()
	{
		parent::__construct("localhost","postgres","root123","olympos_0.1");
	}
	public function checkEmailPass($email,$pass){
		$result = $this->selectGetResult(DBData::getMainUserTable(),
			DBData::$emailDataAdd,DBData::$emailDataAdd." LIKE '".$email."' AND ".DBData::$mainUserActive."=true AND
            ".DBData::$mainUserPass." LIKE '".md5($pass)."'" ,
			"INNER JOIN ".DBData::getEmailDataTable()." ON
                                    ".DBData::getMainUserTable().".".DBData::$mainUserEmailID."=
                                    ".DBData::getEmailDataTable().".".DBData::$emailDataID);
		if(pg_num_rows($result)>0){
			return true;
		}
		else {
			return false;
		}
	}
	public function checkEmail($email){
		$result = $this->selectGetResult(DBData::getMainUserTable(),
			DBData::$emailDataAdd,DBData::$emailDataAdd." LIKE '".$email."' AND ".DBData::$mainUserActive."=true",
			"INNER JOIN ".DBData::getEmailDataTable()." ON
                                    ".DBData::getMainUserTable().".".DBData::$mainUserEmailID."=
                                    ".DBData::getEmailDataTable().".".DBData::$emailDataID);
		if(pg_num_rows($result)>0){
			return true;
		}
		else {
			return false;
		}
	}
	public function loadLoginUser($email, $pass){
		$row = $this->select(DBData::getMainUserTable(),
			"*",
			DBData::$emailDataAdd." LIKE '".$email."' AND ".DBData::$mainUserActive."=true AND
            ".DBData::$mainUserPass." LIKE '".md5($pass)."'" ,
			"INNER JOIN ".DBData::getEmailDataTable()." ON
                            ".DBData::getMainUserTable().".".DBData::$mainUserEmailID."=
                            ".DBData::getEmailDataTable().".".DBData::$emailDataID."
            INNER JOIN ".DBData::getTelefonDataTable()." ON
                            ".DBData::getMainUserTable().".".DBData::$mainUserTelefonID."=
                            ".DBData::getTelefonDataTable().".".DBData::$telefonDataID);
		$user = new User($row);

		$user =$this->refreshUserPermission($user);
		return $user;

	}
	public function refreshUserPermission(User $user){
		$perQuery = $this->select(DBData::getPermissionTable(),"*",
			DBData::$permissionMainUserID."=".$user->getId());

		$user->setAdmin((strcmp($perQuery[DBData::$permissionAdmin],"t")==0));
		$user->setModerator((strcmp($perQuery[DBData::$permissionModerator],"t")==0));
		$user->setVisitor((strcmp($perQuery[DBData::$permissionVisitor],"t")==0));
		$user->setFederationLeader((strcmp($perQuery[DBData::$permissionFedLeader],"t")==0));
		$user->setClubLeader((strcmp($perQuery[DBData::$permissionClubLeader],"t")==0));
		$user->setJudge((strcmp($perQuery[DBData::$permissionJudge],"t")==0));
		$user->setTrainer((strcmp($perQuery[DBData::$permissionTrainer],"t")==0));
		$user->setMember((strcmp($perQuery[DBData::$permissionMember],"t")==0));
		return $user;
	}
	public function isActiveUser($id){
		$row = $this->select(DBData::getMainUserTable(),
				"*",
				DBData::$mainUserID." = ".$id." AND ".DBData::$mainUserActive."=true" ,
				"INNER JOIN ".DBData::getEmailDataTable()." ON
                            ".DBData::getMainUserTable().".".DBData::$mainUserEmailID."=
                            ".DBData::getEmailDataTable().".".DBData::$emailDataID."
            INNER JOIN ".DBData::getTelefonDataTable()." ON
                            ".DBData::getMainUserTable().".".DBData::$mainUserTelefonID."=
                            ".DBData::getTelefonDataTable().".".DBData::$telefonDataID);
		if($row ==null){
			return false;
		}
		else {
			return true;
		}
	}
	public function loadUser($id){
		$row = $this->select(DBData::getMainUserTable(),
				"*",
				DBData::$mainUserID." = ".$id." AND ".DBData::$mainUserActive."=true" ,
				"INNER JOIN ".DBData::getEmailDataTable()." ON
                            ".DBData::getMainUserTable().".".DBData::$mainUserEmailID."=
                            ".DBData::getEmailDataTable().".".DBData::$emailDataID."
            INNER JOIN ".DBData::getTelefonDataTable()." ON
                            ".DBData::getMainUserTable().".".DBData::$mainUserTelefonID."=
                            ".DBData::getTelefonDataTable().".".DBData::$telefonDataID);
		$user = new User($row);

		$user =$this->refreshUserPermission($user);
		return $user;
	}
	public function regUser($name,$email,$tel,$pass){
		$this->Connect();
		$query = "with email as (
            ".$this->returnInsertQuery(DBData::getEmailDataTable(),
						"*",
						"default,'".$email."'",
						"returning ".DBData::$emailDataID)."
        ),
        telefon as (
            ".$this->returnInsertQuery(DBData::getTelefonDataTable(),
						"*",
						"default,'".$tel."'",
						"returning ".DBData::$telefonDataID)."
        ),
        userInsert as (
               ".$this->returnInsertQuery(DBData::getMainUserTable(),"*",
						"default,1,(select ".DBData::$emailDataID." from email),(select ".DBData::$telefonDataID." from telefon),
                '".$name."','".md5($pass)."',true,NOW(),NOW()","returning ".DBData::$mainUserID)."
        ),
        permission as (".$this->returnInsertQuery(DBData::getPermissionTable(),DBData::$permissionMainUserID
						,"(select ".DBData::$mainUserID." from userInsert)")."
        )
        ".$this->update(DBData::getPermissionTable(),DBData::$permissionVisitor."=TRUE",
						DBData::$permissionMainUserID."=(select".DBData::$mainUserID." from userInsert)");
		$temp = $this->sql($query);
		$this->ConnClose();

		return $temp;

	}
}