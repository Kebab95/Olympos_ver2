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
			"Left JOIN ".DBData::getEmailDataTable()." ON
                            ".DBData::getMainUserTable().".".DBData::$mainUserEmailID."=
                            ".DBData::getEmailDataTable().".".DBData::$emailDataID."
            Left JOIN ".DBData::getTelefonDataTable()." ON
                            ".DBData::getMainUserTable().".".DBData::$mainUserTelefonID."=
                            ".DBData::getTelefonDataTable().".".DBData::$telefonDataID."
            Left Join
				  data.member_data
				    On data.member_data.md_muid = data.main_user.mu_id Left Join
				  data.belt_grades_data
				    On data.member_data.md_beltgradesid = data.belt_grades_data.bgd_id");
		if($row){
			if(isset($row[DBData::$memberDataID])){
				$user = SportUser::createWithDB($row);
			}
			else {
				$user = User::createWithDB($row);
			}

			$user =self::$DBTasks->refreshUserPermission($user);
			return $user;
		}
		else {
			return null;
		}

	}
	public static function loadUserWithoutActive($id){
		$row = self::$DBTasks->select(DBData::getMainUserTable(),"*",DBData::$mainUserID." = ".$id,
				"Left JOIN ".DBData::getEmailDataTable()." ON
                            ".DBData::getMainUserTable().".".DBData::$mainUserEmailID."=
                            ".DBData::getEmailDataTable().".".DBData::$emailDataID."
            Left JOIN ".DBData::getTelefonDataTable()." ON
                            ".DBData::getMainUserTable().".".DBData::$mainUserTelefonID."=
                            ".DBData::getTelefonDataTable().".".DBData::$telefonDataID."
            Left Join
				  data.member_data
				    On data.member_data.md_muid = data.main_user.mu_id Left Join
				  data.belt_grades_data
				    On data.member_data.md_beltgradesid = data.belt_grades_data.bgd_id");
		if($row){
			if(isset($row[DBData::$memberDataID])){
				$user = SportUser::createWithDB($row);
			}
			else {
				$user = User::createWithDB($row);
			}

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
			/*
			$result = self::getDBTasks()->selectGetResult($orgTable." as orgD",DBData::$mainUserID,
				$orgMUID."=".$leaderMUID." and ".DBData::$mainUserActive."=true",
				"inner join ".DBData::getMainUserTable()." as muD on
					orgD.".$orgID."=muD.".DBData::$mainUserID. "
				INNER JOIN ".DBData::getOrganizationTable()." ON
					".DBData::getOrganizationTable().".".DBData::$orgMainUserID."=muD.".DBData::$mainUserID);
			*/
			$result = self::$DBTasks->selectGetResult($orgTable." as orgD","*,telefon.".DBData::$telefonDataNum." as tel_num,fax.".DBData::$telefonDataNum." as fax_num",
					$orgMUID."=".$leaderMUID. " AND ".DBData::$mainUserActive."=true",
					"JOIN ".DBData::getMainUserTable()." ON ".
					"orgD.".$orgID."=".DBData::getMainUserTable().".".DBData::$mainUserID."
					JOIN ".DBData::getOrganizationTable()." ON
					".DBData::getOrganizationTable().".".DBData::$orgMainUserID."=".DBData::getMainUserTable().".".DBData::$mainUserID."
					JOIN ".DBData::getPostalAddDataTable()." ON
					".DBData::getPostalAddDataTable().".".DBData::$postalAddID."=".DBData::getOrganizationTable().".".DBData::$orgPostalAddID."
					JOIN ".DBData::getEmailDataTable()." ON
					".DBData::getEmailDataTable().".".DBData::$emailDataID."=".DBData::getMainUserTable().".".DBData::$mainUserEmailID."
					JOIN ".DBData::getTelefonDataTable()." as telefon ON
					telefon.".DBData::$telefonDataID."=".DBData::getMainUserTable().".".DBData::$mainUserTelefonID."
					LEFT JOIN ".DBData::getTelefonDataTable()." as fax ON
					fax.".DBData::$telefonDataID."=".DBData::getOrganizationTable().".".DBData::$orgFaxNumID);
			if(is_null($result)){
				return null;
			}
			else {
				$temp = array();
				while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
					array_push($temp,Organization::createWithDB($row));
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

	public static function loadOrg($orgID){
		$test = self::getDBTasks()->select(DBData::getMainUserTable(),DBData::$mainUserType,DBData::$mainUserID."=".$orgID);
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
				"*,fax.".DBData::$telefonDataNum." as fax_num,
					telefon.".DBData::$telefonDataNum." as tel_num",
				DBData::$mainUserID."= $orgID AND ".DBData::$mainUserActive."=true",

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
				$org = Organization::createWithDB($row);
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
	public static function loadUserClubMember($userID){
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
	public static function loadUserFederationMember($clubID){
		if(is_array($clubID)){
			$val ="(";
			/** @var Organization $item */
			foreach ($clubID as $key => $item) {
				$val.=$item->getId();
				if(isset($clubID[$key+1])){
				    $val.=",";
				}
			}
			$val .=")";
			$result = self::getDBTasks()->sqlWithConn('Select
  org.fed_mship_history.fh_fed_id
From
  org.fed_mship_history WHERE org.fed_mship_history.fh_club_id IN '.$val. ' AND
    org.fed_mship_history.fh_req_acapted=TRUE AND org.fed_mship_history.fh_delete =FALSE');
		}
		else {
			$result = self::getDBTasks()->sqlWithConn('Select
  org.fed_mship_history.fh_fed_id
From
  org.fed_mship_history WHERE org.fed_mship_history.fh_club_id = '.$clubID. ' AND
    org.fed_mship_history.fh_req_acapted=TRUE AND org.fed_mship_history.fh_delete =FALSE');
		}

		if($result != null && $result){
			$temp = array();

			while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
				$user = self::loadOrg($row["fh_fed_id"]);
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
			DBData::$emailDataAdd." LIKE '".strtolower($email)."' AND ".DBData::$mainUserActive."=true AND
            ".DBData::$mainUserPass." LIKE '".md5($pass)."'" ,
			"INNER JOIN ".DBData::getEmailDataTable()." ON
                            ".DBData::getMainUserTable().".".DBData::$mainUserEmailID."=
                            ".DBData::getEmailDataTable().".".DBData::$emailDataID."
            INNER JOIN ".DBData::getTelefonDataTable()." ON
                            ".DBData::getMainUserTable().".".DBData::$mainUserTelefonID."=
                            ".DBData::getTelefonDataTable().".".DBData::$telefonDataID);
		$user = User::createWithDB($row);

		$user =self::getDBTasks()->refreshUserPermission($user);
		return $user;

	}
	public static function loadFedMember($fedID){
		$result2 = self::getDBTasks()->sqlWithConn('Select
  org.fed_mship_history.fh_club_id
From
  org.fed_mship_history
  WHERE org.fed_mship_history.fh_fed_id='.$fedID);
		if($result2 != null){
			$temp = array();

			while($row = pg_fetch_row($result2, NULL, PGSQL_ASSOC)){
				$tempOrg = self::loadOrg($row["fh_club_id"]);

				array_push($temp,$tempOrg);
			}


			return $temp;
		}
		else {
			return null;
		}
	}
	public static function loadClubMember($clubID){
		$result = self::getDBTasks()->selectGetResult(DBData::getClubMemberHistoryTable()." as mh","*",
			DBData::$chClubID."=".$clubID." AND ".DBData::$chCurrent."=true AND ch_req_accepted = true  AND ch_delete=false
    Order By mu.".DBData::$mainUserCreateTime." ASC",
			"join ".DBData::getMainUserTable()." as mu on
				mh.".DBData::$chMemberID." = mu.".DBData::$mainUserID."
			LEFT JOIN ".DBData::getTelefonDataTable()." ON
			".DBData::getTelefonDataTable().".".DBData::$telefonDataID."=mu.".DBData::$mainUserTelefonID."
			LEFT JOIN ".DBData::getEmailDataTable()." ON
			".DBData::getEmailDataTable().".".DBData::$emailDataID."=mu.".DBData::$mainUserEmailID."
			Left Join ".DBData::getMemberDataTable()."
                    On ".DBData::getMemberDataTable().".".DBData::$memberDataMuID." = mu.".DBData::$mainUserID."
            Left Join ".DBData::getBeltGradesDataTable()."
    On ".DBData::getMemberDataTable().".".DBData::$memberDataGradesBeltID." = ".DBData::getBeltGradesDataTable().".".DBData::$beltGradesID);
		if($result != null){
			$temp = array();

			while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
				if(isset($row[DBData::$memberDataID])){
					$user = SportUser::createWithDB($row);
				}
				else {
					$user = User::createWithDB($row);
				}

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
	public static function loadCCCData($contestID=null,$competetionID=null,$categoryID=null){
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
			$where.=" AND ccc_delete=false";
			$join ="Inner Join ".DBData::getContestTable()."
					    On ".DBData::getConnectionCCCTable().".".DBData::$connCCC_ContestID." = ".DBData::getContestTable().".".DBData::$contestID."
				    Inner Join ".DBData::getCompetetionsTable()."
					    On  ".DBData::getConnectionCCCTable().".".DBData::$connCCC_CompID." = ".DBData::getCompetetionsTable().".".DBData::$competetionsID."
				    Left Join ".DBData::getCompCategoryTable()."
					    On  ".DBData::getConnectionCCCTable().".".DBData::$connCCC_CatID." = ".DBData::getCompCategoryTable().".".DBData::$compCatID."
				    Left Join ".DBData::getAgeGroupTable()."
					    On ".DBData::getCompCategoryTable().".".DBData::$compCatAgeGrpID." = ".DBData::getAgeGroupTable().".".DBData::$ageGrpID."
				    Left Join ".DBData::getPersonalGroupTable()."
					    On ".DBData::getCompCategoryTable().".".DBData::$compCatPersonalGrpID." = ".DBData::getPersonalGroupTable().".".DBData::$personalGrpID."
				    Inner Join ".DBData::getPostalAddDataTable()."
					    On ".DBData::getContestTable().".".DBData::$contestLocaleID." =".DBData::getPostalAddDataTable().".".DBData::$postalAddID."
				    Inner Join ".DBData::getContestCompTypesTable()."
				        On ".DBData::getCompetetionsTable().".".DBData::$competetionsTypeID."=".DBData::getContestCompTypesTable().".".DBData::$compTypesID;
			$result = self::$DBTasks->selectGetResult(DBData::getConnectionCCCTable(),
								"*",
								$where
								,$join);
			if(pg_num_rows($result)>0){
				$array = array();
				$i = 0;
				while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
					$array[$i][DBData::$connCCC_ContestID]=Contest::createWithDB($row);
					$array[$i][DBData::$connCCC_CompID]=Competetion::createWithDB($row);
					$array[$i][DBData::$connCCC_CatID]=CompCategory::createWithDB($row);
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
			/*
			if(count($array)>0){
				return $array;
			}
			else {
				return null;
			}
			*/

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
	public static function loadCategory($catID){
		$row = self::$DBTasks->select(DBData::getCompCategoryTable(),"*",DBData::$compCatID."=".$catID,
				"Inner Join ".DBData::getAgeGroupTable()."
    On ".DBData::getCompCategoryTable().".".DBData::$compCatAgeGrpID." = ".DBData::getAgeGroupTable().".".DBData::$ageGrpID."
			  Inner Join ".DBData::getPersonalGroupTable()."
			    On ".DBData::getCompCategoryTable().".".DBData::$compCatPersonalGrpID." =  ".DBData::getPersonalGroupTable().".".DBData::$personalGrpID);
		if($row !=null)
			return CompCategory::createWithDB($row);
		else
			return null;
	}
	public static function loadTechnicalLeaderboard($cccID){
		$back = array();
		$leaderboardRes = self::$DBTasks->sqlWithConn('Select
							  *
							From
							  contest_data.technical_strugle_data
							Where
							  contest_data.technical_strugle_data.ts_ccc_id = '.$cccID.' And
							  contest_data.technical_strugle_data.ts_use = True
							Order By
							  contest_data.technical_strugle_data.ts_racer_point Desc');
		$i = 1;
		$valami = "";
		while($lead =pg_fetch_row($leaderboardRes, NULL, PGSQL_ASSOC)){
			$back[($i-1)]["rated"] = $i;
			$back[($i-1)]["user_id"] = $lead["ts_racer_id"];
			$user = DBLoad::loadUserWithoutActive($lead["ts_racer_id"]);
			$back[($i-1)]["user_name"] = $user->getName();
			$back[($i-1)]["user_point"] = $lead["ts_racer_point"];
			$i++;
		}
		if(count($back)>0){
			return $back;
		}
		else {
			return null;
		}
	}
	public static function loadFightLeaderboard($cccID){
		$userArray = array();
		$allUseronLeaderBoardRes = self::$DBTasks->sqlWithConn('Select
				  *
				From
				  contest_data.strugle_data
				Where
				  contest_data.strugle_data.s_ccc_id = '.$cccID.' And
				  contest_data.strugle_data.s_circle = 1
				Order By
				  contest_data.strugle_data.s_circle Desc,
				  contest_data.strugle_data.s_lctime Desc');
		while($lead =pg_fetch_row($allUseronLeaderBoardRes, NULL, PGSQL_ASSOC)){
			$userArray[$lead["s_racer_1"]] = true;
			$userArray[$lead["s_racer_2"]] = true;
		}
		$leaderboardRes = self::$DBTasks->sqlWithConn('Select
				  *
				From
				  contest_data.strugle_data
				Where
				  contest_data.strugle_data.s_ccc_id = '.$cccID.'
				Order By
				  contest_data.strugle_data.s_circle Desc,
				  contest_data.strugle_data.s_lctime Desc');
		$i = 1;
		$leaderboardArray = array();
		while($lead =pg_fetch_row($leaderboardRes, NULL, PGSQL_ASSOC)){
			foreach ($userArray as $key => $value) {
				if($key == $lead["s_winner_id"]){
				    if($value){
					    $leaderboardArray[($i-1)]["rated"] = $i;
					    $leaderboardArray[($i-1)]["user_id"] = $lead["s_winner_id"];
					    $user = DBLoad::loadUserWithoutActive($lead["s_winner_id"]);
					    $leaderboardArray[($i-1)]["user_name"] = $user->getName();
					    $userArray[$key] = false;
						$i++;
				    }
					if($key != $lead["s_racer_1"]){
						if($userArray[$lead["s_racer_1"]]){
							$leaderboardArray[($i-1)]["rated"] = $i;
							$leaderboardArray[($i-1)]["user_id"] = $lead["s_racer_1"];
							$user = DBLoad::loadUserWithoutActive($lead["s_racer_1"]);
							$leaderboardArray[($i-1)]["user_name"] = $user->getName();
							$userArray[$lead["s_racer_1"]] = false;
							$i++;
						}
					}
					else {
						if($userArray[$lead["s_racer_2"]]){
							$leaderboardArray[($i-1)]["rated"] = $i;
							$leaderboardArray[($i-1)]["user_id"] = $lead["s_racer_2"];
							$user = DBLoad::loadUserWithoutActive($lead["s_racer_2"]);
							$leaderboardArray[($i-1)]["user_name"] = $user->getName();
							$userArray[$lead["s_racer_2"]] = false;
							$i++;
						}
					}
				}
			}
		}
		if(count($leaderboardArray)>0){
			return $leaderboardArray;
		}
		else {
			return null;
		}
	}

}