<?php
$orgValue = array();
$isLeader = UserTasks::isFederationLeader();
if(UserTasks::isFederationLeader()){

	$org = DBLoad::loadOrgLeader(UserTasks::getUser()->getId(),2);
	//$org["member"] = DBLoad::loadUserFederationMember($org);
	/** @var Organization $item */
	foreach ($org as $item) {
		$temp["org"] = $item;
		$temp["members"] = DBLoad::loadFedMember($item->getId());
		array_push($orgValue,$temp);
	}
}
else if(UserTasks::isFederationMember()){
	$fed =  DBLoad::loadUserFederationMember(DBLoad::loadOrgLeader(UserTasks::getUser()->getId(),3));
	/** @var Organization $item */
	foreach ($fed as $item) {
		$temp["org"] = $item;
		$temp["members"] = DBLoad::loadFedMember($item->getId());
		array_push($orgValue,$temp);
	}
}