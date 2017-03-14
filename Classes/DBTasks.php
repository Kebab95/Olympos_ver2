<?php
class DBTasks extends Database
{
	public function __construct()
	{
		parent::__construct("localhost","postgres","root123","olympos_0.1");
	}
	public function checkEmailPass($email,$pass){
		$result = $this->selectGetResult(DBData::getMainUserTable(),
			DBData::$emailDataAdd,DBData::$emailDataAdd." = '".strtolower($email)."' AND
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
			DBData::$emailDataAdd,DBData::$emailDataAdd." = '".strtolower($email)."'");
		if(pg_num_rows($result)>0){
			return true;
		}
		else {
			return false;
		}
	}
	public function joinClub($clubID,$memberID){
		$query =  $this->sqlWithConn('INSERT INTO org.club_mship_history
											(ch_club_id,
											ch_member_id,
											ch_current)
											VALUES
											('.$clubID.',
											'.$memberID.',
											false)');

		return $query;
		/*
		if($query){
			//$temp = $this->update(DBData::getPermissionTable(),DBData::$permissionMember."=true",DBData::$permissionMainUserID."=$memberID");
			return true;

		}
		else {
			return false;
		}
		*/

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
	public function joinFed($fedID,$clubID){
		$query =  $this->sqlWithConn('INSERT INTO org.fed_mship_history
											(fh_fed_id,
											fh_club_id,
											fh_current)
											VALUES
											('.$fedID.',
											'.$clubID.',
											false)');

		return $query;
		/*
		if($query){
			//$temp = $this->update(DBData::getPermissionTable(),DBData::$permissionMember."=true",DBData::$permissionMainUserID."=$memberID");
			return true;

		}
		else {
			return false;
		}
		*/

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
		$user->setFedMember(((strcmp($perQuery[DBData::$permissionFedMember],"t")==0)));
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
	public function insertComp($compData){
		if(is_array($compData)){
			if(is_array($compData[0])){
				$etcValues="";
				for($i=1; $i<count($compData); $i++){
				    $etcValues.=",('".$compData[$i][DBData::$competetionsTitle]."',
	                                ".$compData[$i][DBData::$competetionsTypeID].",
	                                ".$compData[$i][DBData::$competetionsMuID].")";
				}
				$id = $this->insert(DBData::getCompetetionsTable(),
						DBData::$competetionsTitle.","
						.DBData::$competetionsTypeID.","
						.DBData::$competetionsMuID,
						"'".$compData[0][DBData::$competetionsTitle]."',
							".$compData[0][DBData::$competetionsTypeID].",
							".$compData[0][DBData::$competetionsMuID],
						$etcValues." returning ".DBData::$competetionsID);
				if(pg_num_rows($id)>0){
					$array = array();
					echo $id."<br>";
					while($row = pg_fetch_row($id, NULL, PGSQL_ASSOC)){
						//echo $row["id"];
						array_push($array,$row[DBData::$competetionsID]);
					}
					if(count($array)>0){
						return $array;
					}
					else{
						return false;
					}
				}
				else {
					return false;
				}

			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}
	public function insertCompAndConnectToCCC(array $compData,int $contestID){
		$compIDs = $this->insertComp($compData);
		if(is_bool($compIDs) && !$compIDs){
			echo "itt a gond2";
		    return $compIDs;
		}
		else {
			$data = array();

			for($i=0; $i<count($compIDs); $i++){
				echo $compIDs[$i]."<br>";
				$data[$i][DBData::$connCCC_ContestID] = $contestID;
				$data[$i][DBData::$connCCC_CompID] =$compIDs[$i];
			}
			if($this->createConnectToCCC($data)){
				return true;
			}
			else {
				echo "itt a gond";
				return false;
			}

		}
	}
	/*
	*   CCC = Contest, Competetions, Category
    *   Verseny, Versenyszám, Kategoria
	*/
	public function createConnectToCCC(array $data){

		if(count($data)>1){
			$moreInsert ="";
			for($i=1; $i<count($data); $i++){
				$moreInsert.=",(".$data[$i][DBData::$connCCC_ContestID].",".
						$data[$i][DBData::$connCCC_CompID].
						(isset($data[$i][DBData::$connCCC_CatID])?
								",".$data[$i][DBData::$connCCC_CatID]:",null").")";
			}
		}
		if($this->insert(DBData::getConnectionCCCTable(),
						DBData::$connCCC_ContestID.",".
						DBData::$connCCC_CompID.",".
						DBData::$connCCC_CatID,

						$data[0][DBData::$connCCC_ContestID].",".
						$data[0][DBData::$connCCC_CompID].
						(isset($data[0][DBData::$connCCC_CatID])?
								",".$data[0][DBData::$connCCC_CatID]:",null")
						,(isset($moreInsert)?$moreInsert:null))){
		    return true;
		}
		else {
			return false;
		}

	}






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
	public function createContest(array $cdJSON){
		$query = $this->returnFunctionSelect(DBData::getCreateContestFunction($cdJSON) ." as id");
		$this->Connect();
		$temp = $this->sql($query);
		if($temp){
			$row = pg_fetch_row($temp, NULL, PGSQL_ASSOC);
			$this->ConnClose();
			return $row["id"];
		}
		else {
			$this->ConnClose();
			return false;
		}

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
	}
	public function regUser($name,$type,$email,$tel,$pass,$bday,$sex){
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
                '".$name."','".md5($pass)."',false,NOW(),NOW(),'".$bday."',".($sex==0?"true":"false"),"returning ".DBData::$mainUserID)."
        )
        ".$this->returnInsertQuery(DBData::getPermissionTable(),DBData::$permissionMainUserID.",".DBData::$permissionVisitor
						,"(select ".DBData::$mainUserID." from userInsert),TRUE","returning ".DBData::$permissionMainUserID);
		$temp = $this->sql($query);
		$this->ConnClose();
		$row = pg_fetch_row($temp, NULL, PGSQL_ASSOC);
		if($row[DBData::$permissionMainUserID] != null){
			return true;
			/*
			$code = $this->RandomString(10);
			$asd =$this->sqlWithConn('INSERT INTO data.email_request_data (erd_gen_code,erd_mu_id)
								VALUES (\''.$code.'\',\''.$row[DBData::$permissionMainUserID].'\')');
			if($asd){
				$emailText="<html><head><title>Olympos regisztráció</title></head><body>REgisztrált az Olympos weboldalra. Regsztrálását itt tudja véglegesíteni: </body></html>";
				$this->SendEmail($email,"Regisztrációs email","");
			}else {
				return false;
			}
			*/
		}
		else {
			return false;
		}

	}
	public function RandomString($lenght)
	{
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$randstring = '';
		for ($i = 0; $i < $lenght; $i++) {
			$randstring = $characters[rand(0, strlen($characters))];
		}
		return $randstring;
	}
	public function SendEmail($sendTo,$title,$text){
		mail($sendTo,
				$title,
				$text,
				"From: olymposinfo17@gmail.com\r\n");
	}
}