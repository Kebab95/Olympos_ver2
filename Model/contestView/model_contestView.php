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
if($creator){
	$data[DBData::$contestIsEntry] = $contest->getIsEntry();
}

$data[DBData::$contestID] = $contest->getId();

$array = DBLoad::loadCCCids($contest->getId());
if($array!=null){

	$i=0;
	foreach ($array as $value) {
		$data[DBData::getCompetetionsTable()][$i] = DBLoad::loadCompetetion($value[DBData::$connCCC_CompID]);
		$i++;
	}
}
$inBody ="View/contestView/view_contestView.php";

