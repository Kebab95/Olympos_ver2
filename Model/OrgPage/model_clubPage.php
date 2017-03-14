<?php
$orgTitle = "Egyesületek";
$orgName ="Egyesület";
$all=DBLoad::loadAllClub();
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
		$member = (UserTasks::getUser()->getId() == $item->getLeaderID());
		$asdRes = $DBTasks->sqlWithConn('Select
				  org.club_mship_history.ch_member_id
				From
				  org.club_mship_history
				Where
				  org.club_mship_history.ch_club_id = '.$item->getId().' AND
				  org.club_mship_history.ch_current = true');
		while($asd = pg_fetch_row($asdRes, NULL, PGSQL_ASSOC)){
			if($asd["ch_member_id"] == UserTasks::getUser()->getId()){
			    $member = true;
			}
		}
		$orgList[$key]["member"] = $member;
	}

	$pagination = array();
	$i = 10;
	$a = 1;
	while($i<count($orgList)){
		$i+=10;
		$pagination[$a] = "?nav=club&&page=".$a;
		$a++;
	}
}
