<?php
class DBTasks extends Database
{
	public function __construct()
	{
		parent::__construct("localhost","postgres","root123","olympos_0.1");
	}
	public function checkEmailPass($email,$pass){
		$result = $this->selectGetResult(DBData::getMainUserTable(),
			DBData::$emailDataAdd,DBData::$emailDataAdd." = '".$email."' AND
            ".DBData::$mainUserPass." = '".md5($pass)."'" ,
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
		$result = $this->selectGetResult(DBData::getEmailDataTable(),
			DBData::$emailDataAdd,DBData::$emailDataAdd." = '".$email."'");
		if(pg_num_rows($result)>0){
			return true;
		}
		else {
			return false;
		}
	}
	public function joinClub($clubID,$memberID){
		$query = $this->insert(DBData::getClubMemberHistoryTable(),"*","default,".$clubID.",".$memberID.",true,NOW(),NOW()");

		if($query){
			$temp = $this->update(DBData::getPermissionTable(),DBData::$permissionMember."=true",DBData::$permissionMainUserID."=$memberID");
			return $temp;

		}
		else {
			return $query;
		}

		/*
		$row = $this->insert(DBData::getClubMemberHistoryTable(),"*","default,".$clubID.",".$memberID.",true,NOW(),NOW()","RETURNING ".DBData::$chID);
		if(is_null($row)){
			return false;
		}
		else {
			return true;
		}
		*/
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

	public function isUserClubMember($userID)
	{
		$result = $this->selectGetResult(DBData::getClubMemberHistoryTable(),"*",DBData::$chMemberID."=".$userID." AND
									".DBData::$chCurrent."=true");
		if(pg_num_rows($result)>0){
			return true;
		}
		else {
			return false;
		}
	}


	/**
	 * @param $leaderMUID
	 * @param $type
	 */




	/*
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
		if($row){
			$user = new User($row);

			$user =$this->refreshUserPermission($user);
			return $user;
		}
		else {
			return null;
		}

	}
	*/
	public function insertOrganization($leaderID, $name, $type, $shortName, $email, $tel, $fax, $regNum, $taxNum, $pCode, $pTown, $pStreet, $website, $title)
	{
		$leader ="";
		$columm="";
		switch($type){
			case 2: $leader=$this->returnInsertQuery(DBData::getFedLeaderTable(),"*","default,".$leaderID.",(select ".DBData::$mainUserID." from userInsert)","returning ".DBData::$fedLeaderMUID);
				$columm=DBData::$permissionFedLeader;break;
			case 3: $leader=$this->returnInsertQuery(DBData::getClubLeaderTable(),"*","default,".$leaderID.",(select ".DBData::$mainUserID." from userInsert)","returning ".DBData::$clubLeaderMUID);
				$columm=DBData::$permissionClubLeader;break;
		}
		$query ="with email as (
						select * from ".DBData::getEmailFunction($email)." as ".DBData::$emailDataID."
					),
					telefon as (
						select * from ".DBData::getTelefonFunction($tel)." as ".DBData::$telefonDataID."
					),
					".($fax!=''?"
					fax as (
						select * from ".DBData::getTelefonFunction($fax)." as ".DBData::$telefonDataID."
					),
					":"")."
					userInsert as (
						 ".$this->returnInsertQuery(DBData::getMainUserTable(),
						"*",
						"default,".$type.",
						(select ".DBData::$emailDataID." from email),
						(select ".DBData::$telefonDataID." from telefon),
                        '".$name."',null,
                        true,NOW(),NOW()",
						"returning ".DBData::$mainUserID)."
					),
					postalAdd as (
						".$this->returnInsertQuery(DBData::getPostalAddDataTable(),
						"*",
						"default,".$pCode.",
						'".$pTown."','".$pStreet."'",
						"returning ".DBData::$postalAddID)."
					),
					orgData as (
						".$this->returnInsertQuery(DBData::getOrganizationTable(),
						"*",
						"default, (select ".DBData::$mainUserID." from userInsert),
						'".$shortName."',
						'".$regNum."',
						(select ".DBData::$postalAddID." from postalAdd),
						".($fax!=''?"(select ".DBData::$telefonDataID." from fax)":"null").",
						".($website!=''?$website:"null").",
						".($title!=''?$title:"null").",
						'".$taxNum."'",
						"returning ".DBData::$orgID)."
					),
					leader as (
						".$leader."
					)
					".$this->returnUpdateQuery(DBData::getPermissionTable(),
								$columm."=true",
								DBData::$permissionMainUserID."=(select * from leader)");
		/*
		//self::regUser($name,$type,$email,$tel,"null");
		$id = $this->getMainUserSeqCurrVal();
		$query ="with postal as (
			".$this->returnInsertQuery(DBData::getPostalAddDataTable(),"*",
						"default,".$pCode.",'".$pTown."','".$pStreet."'","returning ".DBData::$postalAddID)."
		),".($fax!=null?" telefon as (
			".$this->returnInsertQuery(DBData::getTelefonDataTable(),
						"*",
						"default,'".$fax."'",
						"returning ".DBData::$telefonDataID)."
		)
		":"")." org as (
			".$this->returnInsertQuery(DBData::getOrganizationTable(),"*",
						"default,(select last_value from data.main_user_seq),'".$shortName."','".$regNum."',(select ".DBData::$postalAddID." from postal)
						,".($fax!=null?"(select ".DBData::$telefonDataID." from telefon)":"null").",'".$website."','".$title."'
						,'".$taxNum."'","returning ".DBData::$orgID)."
		)".$leader;
		*/
		$this->Connect();
		$temp = $this->sql($query);
		$this->ConnClose();
		return $temp;
	}
	public function createRace(array $rdJSON,array $compDJOSN){
		/*
		$query ="with postalAdd as (
						".$this->returnInsertQuery(DBData::getPostalAddDataTable(),
						"*",
						"default,".$rdJSON["racePCode"].",
						'".$rdJSON["racePTown"]."','".$rdJSON["racePStreet"]."'",
						"returning ".DBData::$postalAddID)."
					)".$this->returnInsertQuery(DBData::getRaceTable(),
						DBData::$raceName.",".
						DBData::$raceDesc.",".
						DBData::$raceOrgID.",".
						DBData::$raceLocaleID.",".
						DBData::$raceDate.",".
						DBData::$raceEntryFee,

						"'".$rdJSON["raceName"]."',".
						"'".$rdJSON["raceDesc"]."',".
						$rdJSON["orgID"].",".
						"(SELECT ".DBData::$postalAddID." FROM postalAdd),".
						"'".$rdJSON["raceDate"]."',".
						$rdJSON["raceFee"],
						"returning ".DBData::$raceID);*/
		$query = $this->returnInsertQuery(DBData::getPostalAddDataTable(),
				"*",
				"default,".$rdJSON[DBData::$postalAddPCode].",
						'".$rdJSON[DBData::$postalAddTown]."','".$rdJSON[DBData::$postalAddStreet]."'",
				"returning ".DBData::$postalAddID);
		$this->Connect();
		$temp = $this->sql($query);
		if(!is_null($temp)){
			while($row = pg_fetch_row($temp, NULL, PGSQL_ASSOC)){
				$id = $row[DBData::$postalAddID];
			}
			$rdJSON[DBData::$raceLocaleID] =$id;
			$createRaceQuery = "SELECT ".DBData::getCreateRaceFunction($rdJSON);

			/*
			 * create table competitions.%I (
	comp_id integer default nextval("competitions.%I"),
	comp_title char(200),
	comp_desc char (3000),
	comp_sex boolean
	)','comp_'|| v_id,'comp_'||  v_id ||'_seq'
			 */

			$temp = $this->sql($createRaceQuery);
			if(!is_null($temp)){

			}
			else {
				throw new Exception('MySQL hiba');
			}

		}
		else {
			throw new Exception('MySQL hiba');
		}
		$this->ConnClose();
		return $temp;
	}
	public function regUser($name,$type,$email,$tel,$pass){
		$this->Connect();
		$query = "with email as (
			select * from ".DBData::getEmailFunction($email)." as ".DBData::$emailDataID."
        ),
        telefon as (
            select * from ".DBData::getTelefonFunction($tel)." as ".DBData::$telefonDataID."
        ),
        userInsert as (
               ".$this->returnInsertQuery(DBData::getMainUserTable(),"*",
						"default,".$type.",(select ".DBData::$emailDataID." from email),(select ".DBData::$telefonDataID." from telefon),
                '".$name."','".md5($pass)."',true,NOW(),NOW()","returning ".DBData::$mainUserID)."
        )
        ".$this->returnInsertQuery(DBData::getPermissionTable(),DBData::$permissionMainUserID.",".DBData::$permissionVisitor
						,"(select ".DBData::$mainUserID." from userInsert),TRUE");
		$temp = $this->sql($query);
		$this->ConnClose();

		return $temp;

	}
}