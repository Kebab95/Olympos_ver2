<?php

class DBLoad
{

	/**
	 * @var DBTasks $DBTasks
	 */
	private static $DBTasks;

	private static function getDBTasks(){
		if(self::$DBTasks == null){
			self::init();
			return self::$DBTasks;
		}
		else {
			return self::$DBTasks;
		}
	}
	public static function init(){
		self::$DBTasks= new DBTasks();
	}

	public static function loadUser($id){
		$row = self::getDBTasks()->select(DBData::getMainUserTable(),
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

			$user =self::$DBTasks->refreshUserPermission($user);
			return $user;
		}
		else {
			return null;
		}

	}

	public static function  loadOrgLeader($leaderMUID, $type){
		if($type==2 || $type==3){
			switch($type){
				case 2:
					$orgTable = DBData::getFedLeaderTable();
					$orgID = DBData::$fedLeaderFEDID;
					$orgMUID =DBData::$fedLeaderMUID;
					break;
				case 3:
					$orgTable = DBData::getClubLeaderTable();
					$orgID = DBData::$clubLeaderCLUBID;
					$orgMUID =DBData::$clubLeaderMUID;
					//echo $orgTable;
					break;
			}
			$result = self::getDBTasks()->selectGetResult($orgTable." as orgD",DBData::$mainUserID,
				$orgMUID."=".$leaderMUID." and ".DBData::$mainUserActive."=true",
				"inner join ".DBData::getMainUserTable()." as muD on
					orgD.".$orgID."=muD.".DBData::$mainUserID);

			if(is_null($result)){
				return null;
			}
			else {
				$temp = array();
				while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
					array_push($temp,self::loadOrg($row[DBData::$mainUserID]));
				}
				return $temp;
			}
			/*
			$query ="select * from ".DBData::getMainUserTable()." as mu

					inner join ".DBData::getEmailDataTable()." as email on
					mu.".DBData::$mainUserEmailID."=email.".DBData::$emailDataID."

					inner join ".DBData::getTelefonDataTable()." as telefon on
					mu.".DBData::$mainUserTelefonID."=telefon.".DBData::$telefonDataID."

					inner join ".DBData::getOrganizationTable()." as org on
					mu.".DBData::$mainUserID."=org.".DBData::$orgMainUserID."

					inner join ".DBData::getPostalAddDataTable()." as postal on
					org.".DBData::$orgPostalAddID."= postal.".DBData::$postalAddID."

					left join ".DBData::getTelefonDataTable()." as fax on
					fax.".DBData::$mainUserTelefonID."=org.".DBData::$orgFaxNumID."

					where ".DBData::$mainUserID."=(
						select ".$orgID." from ".$orgTable." as orgD
						inner join ".DBData::getMainUserTable()." as muD on
						orgD.".$orgID."=muD.".DBData::$mainUserID."
						where ".$orgMUID."=".$leaderMUID." and ".DBData::$mainUserActive."=true
					)";
			*/

		}
		else {
			return null;
		}
	}
	public static function loadAllFed(){
		$result = self::getDBTasks()->selectGetResult(DBData::getMainUserTable(),DBData::$mainUserID,DBData::$mainUserType."=2 AND ".DBData::$mainUserActive."=true");
		$allClub = array();
		while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
			//echo $row[DBData::$mainUserID];
			array_push($allClub,self::loadOrg($row[DBData::$mainUserID]));
		}
		return $allClub;
	}

	public static function loadAllClub(){
		$result = self::getDBTasks()->selectGetResult(DBData::getMainUserTable(),DBData::$mainUserID,DBData::$mainUserType."=3 AND ".DBData::$mainUserActive."=true");
		$allClub = array();
		while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
			//echo $row[DBData::$mainUserID];
			array_push($allClub,self::loadOrg($row[DBData::$mainUserID]));
		}
		return $allClub;
	}

	public static function loadOrg($muID){
		$test = self::getDBTasks()->select(DBData::getMainUserTable(),DBData::$mainUserType,DBData::$mainUserID."=".$muID);
		if($test[DBData::$mainUserType] ==2 || $test[DBData::$mainUserType] ==3 || $test===TRUE){
			$typeNum =$test[DBData::$mainUserType];

			if($typeNum== 2){

				$table =DBData::getFedLeaderTable();
				$column=DBData::$fedLeaderFEDID;
			}
			elseif($typeNum==3){
				$table =DBData::getClubLeaderTable();
				$column=DBData::$clubLeaderCLUBID;
			}
			$row = self::$DBTasks->select(DBData::getMainUserTable()." as mu",
				"*,fax.".DBData::$telefonDataID." as fax_num,
					telefon.".DBData::$telefonDataNum." as tel_num",
				DBData::$mainUserID."= $muID AND ".DBData::$mainUserActive."=true",

				"inner join ".DBData::getEmailDataTable()." as email on
					mu.".DBData::$mainUserEmailID."=email.".DBData::$emailDataID."

					inner join ".DBData::getTelefonDataTable()." as telefon on
					mu.".DBData::$mainUserTelefonID."=telefon.".DBData::$telefonDataID."

					inner join ".DBData::getOrganizationTable()." as org on
					mu.".DBData::$mainUserID."=org.".DBData::$orgMainUserID."

					inner join ".DBData::getPostalAddDataTable()." as postal on
					org.".DBData::$orgPostalAddID."= postal.".DBData::$postalAddID."

					left join ".DBData::getTelefonDataTable()." as fax on
					fax.".DBData::$telefonDataID."=org.".DBData::$orgFaxNumID."

					join ".$table." as leader on
					mu.".DBData::$mainUserID."=leader.".$column."");
			if(is_array($row)){
				$org = new Organization($row);
				return $org;
			}
			else {
				return null;
			}

		}
		else {
			return null;
		}

	}
	public static function loadOrgCompTypes($compID){
		$result = self::getDBTasks()->selectGetResult(DBData::getContestCompTypesTable()
													,DBData::$contestCompTypesID.",".
													DBData::$contestCompTypesName,
													DBData::$contestCompTypesMuID."=".$compID);
		if($result!=null){
			$temp  = array();
			$i =0;
			while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
				$temp[$i] = array($row[DBData::$contestCompTypesID],$row[DBData::$contestCompTypesName]);
				$i++;
			}
			return $temp;
		}
		else {
			return $result;
		}
	}

	/**
	 * @param $leaderID
	 * @return bool
	 */
	public static function loadLeaderContests($leaderID){
		$result =self::$DBTasks->selectGetResult(DBData::getContestTable(),"*",
				"(".DBData::$contestOrgID." in (
								select ".DBData::$fedLeaderFEDID." from ".DBData::getFedLeaderTable()."
								where ".DBData::$fedLeaderMUID."=".$leaderID."
							)
							OR
							".DBData::$contestOrgID." in (
								select ".DBData::$clubLeaderCLUBID." from ".DBData::getClubLeaderTable()."
								where ".DBData::$clubLeaderMUID."=".$leaderID."
							)
						)
						AND ".DBData::$contestDelete."=false
						AND ".DBData::$contestDate." IS NOT NULL
						ORDER BY ".DBData::$contestDate." DESC",
				"JOIN ".DBData::getPostalAddDataTable()." ON ".
				DBData::getPostalAddDataTable().".".DBData::$postalAddID."=".DBData::getContestTable().".".DBData::$contestLocaleID);
		if(pg_num_rows($result)>0){
			if($result!=null){
				$temp  = array();
				$i =0;
				while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
					$temp[$i] = Contest::createWithDB($row);
					$i++;
				}
				return $temp;
			}
			else {
				return $result;
			}
		}
		else {
			return null;
		}
	}
	public static function loadContest($contestID){
		$result = self::$DBTasks->selectGetResult(DBData::getContestTable(),"*",DBData::$contestID."=".$contestID,
				"JOIN ".DBData::getPostalAddDataTable()." ON ".
				DBData::getPostalAddDataTable().".".DBData::$postalAddID." = ".DBData::getContestTable().".".DBData::$contestLocaleID);
		if(pg_num_rows($result)>0){
			$row = pg_fetch_row($result,NULL,PGSQL_ASSOC);
			return Contest::createWithDB($row);
		}
		else {
			return null;
		}
	}
	public static function loadUserOrgMember($userID){
		$result = self::getDBTasks()->selectGetResult(DBData::getClubMemberHistoryTable(),DBData::$chClubID,
			DBData::$chMemberID."=".$userID." AND ".DBData::$chCurrent."=true");
		if($result != null){
			$temp = array();

			while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
				$user = self::loadOrg($row[DBData::$chClubID]);
				array_push($temp,$user);
			}


			return $temp;
		}
		else {
			return null;
		}
	}
	public static function loadLoginUser($email, $pass){
		$row = self::getDBTasks()->select(DBData::getMainUserTable(),
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

		$user =self::getDBTasks()->refreshUserPermission($user);
		return $user;

	}
	public static function loadClubMember($clubID){
		$result = self::getDBTasks()->selectGetResult(DBData::getClubMemberHistoryTable()." as mh",DBData::$mainUserID,
			DBData::$chClubID."=".$clubID." AND ".DBData::$chCurrent."=true",
			"join ".DBData::getMainUserTable()." as mu on
				mh.".DBData::$chMemberID." = mu.".DBData::$mainUserID);
		if($result != null){
			$temp = array();

			while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
				$user = self::loadUser($row[DBData::$mainUserID]);
				array_push($temp,$user);
			}


			return $temp;
		}
		else {
			return null;
		}
	}
	public static function loadPostalAddress($padID){
		$row = self::getDBTasks()->select(DBData::getPostalAddDataTable(),"*",DBData::$postalAddID."=".$padID);
		if($row !=null){
			return new PostalAdd($row[DBData::$postalAddPCode],$row[DBData::$postalAddStreet],$row[DBData::$postalAddTown]);
		}
		else {
			return null;
		}

	}
	public static function loadCCCids($contestID=null,$competetionID=null,$categoryID=null){
		if($contestID!=null || $competetionID!=null || $categoryID!= null){
			$where = "";
			if($contestID!=null){
			    $where .=DBData::$connCCC_ContestID."=".$contestID;
			}
			if($competetionID!=null){
			    if(strlen($where)>0){
			        $where.=" AND ".DBData::$connCCC_CompID."=".$competetionID;
			    }
				else {
					$where.=DBData::$connCCC_CompID."=".$competetionID;
				}
			}
			if($categoryID != null){
			    if(strlen($where)>0){
				    $where.=" AND ".DBData::$connCCC_CatID."=".$categoryID;
			    }
				else {
					$where.=DBData::$connCCC_CatID."=".$categoryID;
				}
			}
			$where.=" AND delete=false";
			$result = self::$DBTasks->selectGetResult(DBData::getConnectionCCCTable(),
														"*",
														$where);
			$array = array();
			$i = 0;
			while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
				$array[$i][DBData::$connCCC_ContestID]=$row[DBData::$connCCC_ContestID];
				$array[$i][DBData::$connCCC_CompID]=$row[DBData::$connCCC_CompID];
				$array[$i][DBData::$connCCC_CatID]=$row[DBData::$connCCC_CatID];
				$i++;
			}
			if(count($array)>0){
				return $array;
			}
			else {
				return null;
			}

		}
		else {
			return null;
		}
	}
	public static function loadCompetetion($compID){
		$row  = self::$DBTasks->select(DBData::getCompetetionsTable(),"*",DBData::getCompetetionsTable().".".DBData::$competetionsID."=".$compID,
										"JOIN ".DBData::getContestCompTypesTable()." ON ".
			DBData::getCompetetionsTable().".".DBData::$competetionsTypeID."=".DBData::getContestCompTypesTable().".".DBData::$compTypesID);
		if($row !=null)
			return Competetion::createWithDB($row);
		else
			return null;
	}

}