<?php
if(UserTasks::getUser() !=null &&(UserTasks::getUser()->isClubLeader() || UserTasks::getUser()->isFederationLeader())){
	$ContestArray = DBLoad::loadLeaderContests(UserTasks::getUser()->getId());
}

$actualContestArray =array();
$result = $DBTasks->selectGetResult(DBData::getContestTable(),"*",
	DBData::$contestClosed."=false AND ".DBData::$contestDate."<NOW()");
while($actualContestRow = $row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
	array_push($actualContestArray,$actualContestRow);
}
