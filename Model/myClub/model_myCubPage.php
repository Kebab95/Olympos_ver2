<?php
/** @var User $obj */
$obj = $_SESSION["User"];
$orgValue = array();
if($obj->isClubLeader()){
	$org = DBLoad::loadOrgLeader($obj->getId(),3);
	/** @var Organization $item */
	foreach ($org as $item) {
		$temp["orgName"] = $item->getName();

		$temp["orgLeaderID"] = $obj->getId();
		$temp["orgLeader"] = $obj->getName();

		$temp["members"] = loadClubMemberToArray(
				DBLoad::loadClubMember($item->getId())
		);

		array_push($orgValue,$temp);
	}


}
else if($obj->isMember()){
	$org = DBLoad::loadUserOrgMember($obj->getId());
	/** @var Organization $item */
	foreach ($org as $item) {
		$temp["orgName"] = $item->getName();

		$temp["orgLeaderID"] = $obj->getId();
		$temp["orgLeader"] = $obj->getName();

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
		$asd["memberCurrent"] = ($_SESSION["User"]->getId()==$member->getId());
		$asd["memberName"] = $member->getName();
		$asd["memberTelefon"] = $member->getTelefon();
		$asd["memberId"] = $member->getId();

		array_push($memberTemp,$asd);
	}
	return $memberTemp;
}