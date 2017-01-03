<?php
$year = date("Y")+10;

/** @var User $user */
$user = $_SESSION["User"];
$UserOrg["Fed"] = DBLoad::loadOrgLeader($user->getId(),2);
$UserOrg["Club"] = DBLoad::loadOrgLeader($user->getId(),3);

$select = array();
/** @var Organization $item */
foreach ($UserOrg["Fed"] as $item) {
	$select[$item->getName()] = $item->getId();
}
/** @var Organization $item */
foreach ($UserOrg["Club"] as $item) {
	$select[$item->getName()] = $item->getId();
}



$raceName= DBData::$raceName;
$raceOrgID= DBData::$raceOrgID;
$raceDesc = DBData::$raceDesc;
$racePCode = DBData::$postalAddPCode;
$raceTown = DBData::$postalAddTown;
$raceStreet = DBData::$postalAddStreet;
$raceDate = DBData::$raceDate;
$raceFee = DBData::$raceEntryFee;