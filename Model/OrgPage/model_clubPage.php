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
if(UserTasks::isLoggedUser()){




}
else {

}