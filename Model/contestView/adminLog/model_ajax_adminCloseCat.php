<?php
include "../../../includeClasses.php";
$DBTasks = new DBTasks();
DBLoad::init();
$DBTasks->Connect();
$DBTasks->sql('UPDATE contest_data.admin_edit_cat SET aec_under_editing=false, aec_ltime=NOW() WHERE
contest_data.admin_edit_cat.aec_adminid = '.$_POST["adminID"].' And
  contest_data.admin_edit_cat.aec_ccc_id = '.$_POST["cccID"]);
$DBTasks->ConnClose();

$contest = $DBTasks->select(DBData::getConnectionCCCTable(),DBData::$connCCC_ContestID,DBData::$connCCC_Id."=".$_POST["cccID"]);
$admin= $DBTasks->select(DBData::getAdministratorTable(),"*",DBData::$adminID."=".$_POST["adminID"]);

$adminName= $admin[DBData::$adminName];
$adminID= $admin[DBData::$adminID];

$contestID = $contest[DBData::$connCCC_ContestID];
$contestName = DBLoad::loadContest($contestID)->getName();
$result = $DBTasks->selectGetResult(DBData::getConnectionCCCTable(),DBData::$connCCC_CompID,
	DBData::$connCCC_ContestID."=".$contestID." AND ".DBData::$connCCC_TakePlace."=true Group By ".DBData::$connCCC_CompID);
$compArray = array();
while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
	array_push($compArray,DBLoad::loadCompetetion($row[DBData::$connCCC_CompID]));
}

include "../../../View/contestView/adminLog/view_adminView.php";