<?php
$error = !isset($_POST["memberArray"]) && !isset($_GET["contestview"]);
if(!$error){
	$where = "";
	foreach ($_POST["memberArray"] as $value) {
		if(strlen($where)>0){
		    $where.=" OR ";
		}
		$where .=DBData::$mainUserID."=".$value;
	}
    $result = $DBTasks->selectGetResult(DBData::getMainUserTable(),DBData::$mainUserID.",".DBData::$mainUserName,$where);
	$compResult = $DBTasks->selectGetResult(DBData::getContestTable(),
		DBData::getCompetetionsTable().".".DBData::$competetionsID.","
		.DBData::getCompetetionsTable().".".DBData::$competetionsTitle,DBData::$contestID."=".$_GET["contestview"]."
		GROUP BY ".DBData::getCompetetionsTable().".".DBData::$competetionsID.","
		.DBData::getCompetetionsTable().".".DBData::$competetionsTitle.",
		".DBData::getContestTable().".".DBData::$contestID,
		"JOIN ".DBData::getConnectionCCCTable()." ON
		".DBData::getConnectionCCCTable().".".DBData::$connCCC_ContestID."=".DBData::getContestTable().".".DBData::$contestID."
		 JOIN ".DBData::getCompetetionsTable()." ON
		 ".DBData::getConnectionCCCTable().".".DBData::$connCCC_CompID."=".DBData::getCompetetionsTable().".".DBData::$competetionsID);
	if(pg_num_rows($result)>0 && pg_num_rows($compResult)>0){
		$memberArray = array();
		while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
			array_push($memberArray,$row);
		}
		$compArray = array();
		while($row = pg_fetch_row($compResult, NULL, PGSQL_ASSOC)){
			array_push($compArray,$row);
		}
	}
	else {
		$error=true;
	}
}