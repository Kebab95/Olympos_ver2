<?php
$contest = DBLoad::loadLeaderContests($_SESSION["User"]->getId());
$haveContest = (count($contest)>0);
if($haveContest){
	$contestVal = array();
	/** @var Contest $item */
	$allContestWithout ="(";
	$i =0;
	foreach ($contest as $item) {
		$contestVal[$i][DBData::$mainUserName] = DBLoad::loadUser($item->getOrgID())->getName();
		$contestVal[$i][DBData::$contestName] = $item->getName();
		$contestVal[$i][DBData::$contestDate] = $item->getDate();
		$contestVal[$i][DBData::$contestLocaleID] = $item->getLocale();
		$contestVal[$i][DBData::$contestID] = $item->getId();

		$allContestWithout.=DBData::$contestOrgID."!=".$item->getOrgID();
		if(count($contest)>($i+1)){
		    $allContestWithout.=" AND ";
		}
		//echo count($contest) . " ". $i;
		$i++;
	}
	$allContestWithout.=")";
}

$result = $DBTasks->selectGetResult(DBData::getContestTable(),"*",
		(isset($allContestWithout)?$allContestWithout." AND ":"").DBData::$contestDelete."=false AND ".DBData::$contestDate." IS NOT NULL
		ORDER BY ".DBData::$contestDate." DESC",
		"JOIN ".DBData::getPostalAddDataTable()." ON ".
		DBData::getPostalAddDataTable().".".DBData::$postalAddID."=".DBData::getContestTable().".".DBData::$contestLocaleID."
		JOIN ".DBData::getMainUserTable()." ON ".
		DBData::getMainUserTable().".".DBData::$mainUserID." = ".DBData::getContestTable().".".DBData::$contestOrgID);
$otherContest = array();
$a = 0;
while ($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
	$item = Contest::createWithDB($row);
	$otherContest[$a][DBData::$mainUserName] =$row[DBData::$mainUserName];
	$otherContest[$a][DBData::$contestName] = $item->getName();
	$otherContest[$a][DBData::$contestDate] = $item->getDate();
	$otherContest[$a][DBData::$contestLocaleID] = $item->getLocale();
	$otherContest[$a][DBData::$contestID] = $item->getId();
	$a++;
}
