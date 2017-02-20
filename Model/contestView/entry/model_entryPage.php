<?php
$contest = DBLoad::loadContest($_GET["contestview"]);
if(UserTasks::getUser()->isClubLeader()){
	/** @var Organization $ClubOrg */
    $UserSwitch=0;
	$ClubOrg= DBLoad::loadOrgLeader(UserTasks::getUser()->getId(),3)[0];
	$ClubMembers = DBLoad::loadClubMember($ClubOrg->getId());
	$GradesResult = $DBTasks->selectGetResult(DBData::getBeltGradesDataTable(),"*",DBData::$beltGradesID.">0 Order by ".DBData::$beltGradesWeight);
	$grades = array();
	while($row = pg_fetch_row($GradesResult, NULL, PGSQL_ASSOC)){
		array_push($grades,$row);
	}

}
else if(UserTasks::getUser()->isFederationLeader()){
	$UserSwitch=1;
}
else if(UserTasks::getUser()->isMember()){
	$UserSwitch=2;
}
else {
	$UserSwitch=3;
}
$contestName = $contest->getName();
$contestID = $contest->getId();
//var_dump($grades);