<?php
$contest = DBLoad::loadContest($_GET["contestview"]);
if(UserTasks::getUser()->isClubLeader()){
	/** @var Organization $ClubOrg */
    $UserSwitch=0;
	$ClubOrg= DBLoad::loadOrgLeader(UserTasks::getUser()->getId(),3)[0];
	$ClubMembers = DBLoad::loadClubMember($ClubOrg->getId());
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