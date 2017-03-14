<?php
$profUser = UserTasks::getUser();

$isSportUser = SportUser::isSportUser(UserTasks::getUser());

$clubMember = $DBTasks->isUserClubMember(UserTasks::getUser()->getId());
$clubleader = UserTasks::isClubLeader();
$fedLeader = UserTasks::isFederationLeader();
$fedMember = UserTasks::isFederationMember();
if($clubleader){
	$club = DBLoad::loadOrgLeader(UserTasks::getUser()->getId(),3);
}
else if($clubMember){
	$org = DBLoad::loadUserClubMember(UserTasks::getUser()->getId());
	$orgValue = array();
	/** @var Organization $item */
	foreach ($org as $item) {
		$temp["orgName"] = $item->getName();
		$temp["orgWebsite"] = $item->getWebSite();
		$temp["orgId"] = $item->getId();
		$temp["orgLeaderID"] = $item->getLeaderID();
		$temp["orgLeader"] = DBLoad::loadUser($temp["orgLeaderID"])->getName();



		array_push($orgValue,$temp);
	}
}

if($fedLeader){
	$fed = DBLoad::loadOrgLeader(UserTasks::getUser()->getId(),2);
}
else if($fedMember){
	$club = DBLoad::loadOrgLeader(UserTasks::getUser()->getId(),3);
	$fed = DBLoad::loadUserFederationMember($club);
	//var_dump($fed);

}