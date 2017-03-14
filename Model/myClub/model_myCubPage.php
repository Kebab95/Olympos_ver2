<?php
/** @var User $obj */
$obj = $_SESSION["User"];
$orgValue = array();
$isLeader = $obj->isClubLeader();
if($isLeader){
	$org = DBLoad::loadOrgLeader($obj->getId(),3);
	/** @var Organization $item */
	foreach ($org as $item) {
		$temp["orgName"] = $item->getName();
		$temp["orgId"] = $item->getId();
		$temp["orgLeaderID"] = $obj->getId();
		$temp["orgLeader"] = $obj->getName();

		$temp["members"] = loadClubMemberToArray(
				DBLoad::loadClubMember($item->getId())
		);

		array_push($orgValue,$temp);
	}


}
else if($obj->isMember()){
	$org = DBLoad::loadUserClubMember($obj->getId());
	/** @var Organization $item */
	foreach ($org as $item) {
		$temp["orgName"] = $item->getName();
		$temp["orgId"] = $item->getId();
		$temp["orgLeaderID"] = $item->getLeaderID();
		$temp["orgLeader"] = DBLoad::loadUser($temp["orgLeaderID"])->getName();

		$temp["members"] = loadClubMemberToArray(
				DBLoad::loadClubMember($item->getId())
		);

		array_push($orgValue,$temp);
	}
}
function loadClubMemberToArray($clubMembers){
	$memberTemp = array();
	/** @var User $member */
	foreach ($clubMembers as $member) {
		$asd["memberCurrent"] = (UserTasks::getUser()->getId()==$member->getId());
		$asd["memberUser"] = $member;

		array_push($memberTemp,$asd);
	}
	return $memberTemp;
}