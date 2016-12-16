<?php

/** @var User $profUser */
$profUser = $_SESSION["User"];
$name = $profUser->getName();
$email = $profUser->getEmail();
$telefon = $profUser->getTelefon();


$clubMember = $DBTasks->isUserClubMember($profUser->getId());
$clubleader = $profUser->isClubLeader();
$fedLeader = $profUser->isFederationLeader();
if($clubleader){
	$club = DBLoad::loadOrgLeader($_SESSION["User"]->getId(),3);


	//Ez egy lsita!!!!
	$clubName= $club[0]->getName();
}

if($fedLeader){
	$fed = DBLoad::loadOrgLeader($_SESSION["User"]->getId(),2);
	$fedName= $fed[0]->getName();
}