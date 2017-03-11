<?php
$contest = DBLoad::loadContest($_GET["contestview"]);
$result = $DBTasks->select(DBData::getMainUserTable(),DBData::$mainUserID,
		DBData::$fedLeaderFEDID."=".$contest->getOrgID()." OR ".DBData::$clubLeaderCLUBID."=".$contest->getOrgID(),
		"left join ".DBData::getFedLeaderTable()." ON ".
			DBData::getMainUserTable().".".DBData::$mainUserID."=".DBData::getFedLeaderTable().".".DBData::$fedLeaderMUID.
		" left join ".DBData::getClubLeaderTable()." ON ".
			DBData::getMainUserTable().".".DBData::$mainUserID."=".DBData::getClubLeaderTable().".".DBData::$clubLeaderMUID);

$creator = (is_numeric($result[DBData::$mainUserID]) && $result[DBData::$mainUserID] == $_SESSION["User"]->getId());
$data[DBData::$contestName] = $contest->getName();
$data[DBData::$contestOrgID] = DBLoad::loadOrg($contest->getOrgID())->getName();
$data[DBData::$contestLocaleID]= $contest->getLocale();
$data[DBData::$contestDate] = $contest->getDate();
$data[DBData::$contestEntryFee] = $contest->getEntryFee();
$data[DBData::$contestDesc] = $contest->getDescription();
$data[DBData::$contestIsEntry] = $contest->getIsEntry();
$data[DBData::$contestDataChecks] = $contest->isDataChecks();

$data[DBData::$contestID] = $contest->getId();

//$array = DBLoad::loadCCCids($data[DBData::$contestID]);
$array = DBLoad::loadCCCData($data[DBData::$contestID]);
if($array!=null){
	$data[DBData::getCompetetionsTable()] = array();
	$i =0;

	$compArray = array();
	foreach ($array as $value) {

		/** @var Competetion $comp */
		$comp = $value[DBData::$connCCC_CompID];
		$compArray[$comp->getId()] = $comp;
		/** @var CompCategory $category */
		$category = $value[DBData::$connCCC_CatID];
		if($category!=null){
			if(isset($data[DBData::getCompetetionsTable()][$comp->getId()])){
				$compCat[$comp->getId()][$i] = $category;
			}
			else {
				$data[DBData::getCompetetionsTable()][$comp->getId()] = $comp;
				$compCat[$comp->getId()][$i] = $category;
			}
			//$data[DBData::getCompetetionsTable()][$i] = $value[DBData::$connCCC_CompID];
			$i++;
		}
		else {
			$data[DBData::getCompetetionsTable()][$comp->getId()] = $comp;
		}

	}
	if($creator){
		if(count($compArray)>0){
			$compPerson = array();
			$ageGrp = array();
			/** @var Competetion $item */
			foreach ($compArray as $item) {
				$compPersonResult = $DBTasks->selectGetResult(DBData::getPersonalGroupTable(),
						"*",DBData::$personalGrpCompID."=".$item->getId());
				if(pg_num_rows($compPersonResult)>0){

					while($row = pg_fetch_row($compPersonResult, NULL, PGSQL_ASSOC)){
						$compPerson[$item->getId()][$row[DBData::$personalGrpID]] = $row;
					}
					//var_dump($compTypes);
				}
				$ageGrpResult = $DBTasks->selectGetResult(DBData::getAgeGroupTable(),
						"*",DBData::$ageGrpCompID."=".$item->getId().
						" AND ". DBData::$ageGrpDelete."=false");
				if(pg_num_rows($ageGrpResult)>0){

					while($row = pg_fetch_row($ageGrpResult, NULL, PGSQL_ASSOC)){
						$ageGrp[$item->getId()][$row[DBData::$ageGrpID]] = $row;
					}
					//var_dump($compTypes);
				}
			}
		}


	}

}
$resultTypes = $DBTasks->selectGetResult(DBData::getContestCompTypesTable(),
		"*",
		DBData::$compTypesMUid."=".$contest->getOrgID()." AND ".DBData::$compTypesDelete." = false");
if(pg_num_rows($resultTypes)>0){
	$compTypesArray =array();
	while($row = pg_fetch_row($resultTypes, NULL, PGSQL_ASSOC)){
		array_push($compTypesArray,CompTypes::createWithDB($row));
	}


}
$DBTasks->Connect();
$beltGrades = $DBTasks->sql("Select
  *
From
  data.knowledge_level");
$DBTasks->ConnClose();
$beltKnowLedge =array();
while($row = pg_fetch_row($beltGrades, NULL, PGSQL_ASSOC)){
	array_push($beltKnowLedge,$row);
}
//var_dump($compTypes);

if($creator && $data[DBData::$contestDataChecks]){
    $administratorResult = $DBTasks->selectGetResult(DBData::getAdministratorTable(),DBData::$adminName.",".DBData::$adminID.",".DBData::$adminGenCode,DBData::$adminConrestID."=".$_GET["contestview"]." AND ad_delete=false");
	$administratorArray = array();
	while($row = pg_fetch_row($administratorResult, NULL, PGSQL_ASSOC)){
		array_push($administratorArray,$row);
	}
}