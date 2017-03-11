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
		$asdRes = $DBTasks->sqlWithConn('Select
				  org.federation_leader.fl_mu_id
				From
				  org.federation_leader
				Where
				  org.federation_leader.fl_fed_id ='.$item->getId());
		while($asd = pg_fetch_row($asdRes, NULL, PGSQL_ASSOC)){
			if($asd["fl_mu_id"] == UserTasks::getUser()->getId()){
				$member = true;
			}
		}
		$orgList[$key]["member"] = $member;

	}

}