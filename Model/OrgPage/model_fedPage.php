<?php
$orgTitle = "Szövetségek";
$orgName ="Szövetség";

$all=DBLoad::loadAllFed();
if($all == null){
	$all = "Nincs ".$orgName." felregisztrálva";
}
else {

	$orgList = array();
	/** @var Organization $item */
	foreach ($all as $key => $item) {
		$orgList[$key]["orgId"] = $item->getId();
		$orgList[$key]["Name"] = $item->getName();
		$orgList[$key]["Telefon"] = $item->getTelefon();

		$user = DBLoad::loadUser($item->getLeaderID());
		if($user == null){
			$orgList[$key]["UserName"] = "Törölt Felhasználó";
			$orgList[$key]["UserId"] = 0;
		}
		else {
			$orgList[$key]["UserName"] = $user->getName();
			$orgList[$key]["UserId"] = $user->getId();
		}
		$member = false;

		if(UserTasks::isFederationMember()){
			$club = DBLoad::loadOrgLeader(UserTasks::getUser()->getId(),3);
			if(count($club)>0){
				$val = "(";
				/** @var Organization $item */
				foreach ($club as $key => $item) {
					$val.=$item->getId();
					if(isset($club[$key+1])){
					    $val.=",";
					}
				}
				$val.=")";
				$asdRes2 = $DBTasks->sqlWithConn('Select
				  COUNT(*) as ossz
				From
				  org.fed_mship_history
				Where
				  org.fed_mship_history.fh_fed_id ='.$item->getId().' AND
				  org.fed_mship_history.fh_club_id IN '.$val);
				if(pg_num_rows($asdRes2)==1){
					$member = true;
				}
			}

		}
		
		$orgList[$key]["member"] = $member;

	}

}