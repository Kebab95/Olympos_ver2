<?php
$clubArray = DBLoad::loadOrgLeader(UserTasks::getUser()->getId(),3);
$fedArray = DBLoad::loadOrgLeader(UserTasks::getUser()->getId(),2);
$requestArray = array();
$orgArray = array();
foreach ($clubArray as $item) {
	array_push($orgArray,$item);
}
foreach ($fedArray as $item) {
	array_push($orgArray,$item);
}
/** @var Organization $org */
$org = $orgArray[0];
if($org->getType()==2){

	$requestRes = $DBTasks->sqlWithConn('Select
  org.fed_mship_history.fh_id,
  org.fed_mship_history.fh_fed_id,
  org.fed_mship_history.fh_club_id,
  data.main_user.mu_name
From
  org.fed_mship_history Inner Join
  data.main_user
    On org.fed_mship_history.fh_club_id = data.main_user.mu_id
Where
  org.fed_mship_history.fh_fed_id = '.$org->getId().' And
  org.fed_mship_history.fh_req_acapted = False AND fh_delete=false');
}
else {

	$requestRes = $DBTasks->sqlWithConn('Select
  org.club_mship_history.ch_id,
  org.club_mship_history.ch_club_id,
  org.club_mship_history.ch_member_id,
  data.main_user.mu_name
From
  org.club_mship_history Inner Join
  data.main_user
    On org.club_mship_history.ch_member_id = data.main_user.mu_id
Where
  org.club_mship_history.ch_club_id = '.$org->getId().' And
  org.club_mship_history.ch_req_accepted = False AND ch_delete=false');


	while($row = pg_fetch_row($requestRes, NULL, PGSQL_ASSOC)){
		array_push($requestArray,$row);
	}
}

