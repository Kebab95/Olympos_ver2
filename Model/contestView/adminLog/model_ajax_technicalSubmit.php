<?php
include "../../../includeClasses.php";
$DBTasks = new DBTasks();
DBLoad::init();
if(isset($_POST["callBack"])){
	$DBTasks->sqlWithConn('update contest.assignment set a_lctime=NOW()
						where a_muid='.$_POST["racerID"].' AND a_ccc_id='.$_POST["cccID"]);

	$DBTasks->sqlWithConn('INSERT INTO contest_data.technical_strugle_data
						(ts_racer_id,
						ts_racer_point,
						ts_ccc_id,
						ts_log,
						ts_use)
						VALUES
						('.$_POST["racerID"].',
						'.$_POST["racerPoint"].',
						'.$_POST["cccID"].',
						\''.$_POST["log"].'\',
						false)');
}
else {
	$DBTasks->sqlWithConn('INSERT INTO contest_data.technical_strugle_data
						(ts_racer_id,
						ts_racer_point,
						ts_ccc_id,
						ts_log)
						VALUES
						('.$_POST["racerID"].',
						'.$_POST["racerPoint"].',
						'.$_POST["cccID"].',
						\''.$_POST["log"].'\')');
}
$strugleResult = $DBTasks->sqlWithConn('Select
  *
From
  contest_data.technical_strugle_data Inner Join
  contest.contest_comp
    On contest_data.technical_strugle_data.ts_ccc_id = contest.contest_comp.ccc_id
    Where
  contest.contest_comp.ccc_id = '.$_POST["cccID"].' AND
  contest_data.technical_strugle_data.ts_use = True
  Order By
  contest_data.technical_strugle_data.ts_ctime');
$strugleArray = array();
if(pg_num_rows($strugleResult)>0){
	while($row =pg_fetch_row($strugleResult, NULL, PGSQL_ASSOC)){
		array_push($strugleArray,$row);
	}
	$userResult =$DBTasks->sqlWithConn('Select
  count(*) as ossz
From
  contest.assignment Inner Join
  contest.contest_comp
    On contest.assignment.a_ccc_id = contest.contest_comp.ccc_id Inner Join
  contest_data.admin_edit_cat
    On contest_data.admin_edit_cat.aec_ccc_id = contest.contest_comp.ccc_id
  Inner Join
  data.main_user
    On contest.assignment.a_muid = data.main_user.mu_id Left Join
  data.email_data
    On data.main_user.mu_email_id = data.email_data.ed_id Left Join
  data.telefon_data
    On data.main_user.mu_telefon_id = data.telefon_data.td_id Inner Join
  data.member_data
    On data.member_data.md_muid = data.main_user.mu_id Inner Join
  data.belt_grades_data
    On data.member_data.md_beltgradesid = data.belt_grades_data.bgd_id
    WHERE contest_data.admin_edit_cat.aec_adminid = '.$_POST["adminID"].' And
  contest.contest_comp.ccc_id = '.$_POST["cccID"]);
	$ossz =pg_fetch_row($userResult, NULL, PGSQL_ASSOC)["ossz"];
	$head = "";
	if(count($strugleArray)==$ossz){
		$leaderBoard = DBLoad::loadTechnicalLeaderboard($_POST["cccID"]);
		foreach ($leaderBoard as $value) {
			$head.='<div class="row">';
			$head.='<div class="col-xs-4">'.$value["rated"].'. Helyezet</div>';
			$head.='<div class="col-xs-6">'.$value["user_name"].'</div>';
			$head.='<div class="col-xs-2">'.$value["user_point"].' Pont</div>';
			$head.='</div>';
		}
	}
	else {
		$head.='<button class="btn btn-success btn-block" id="strugleStart" onclick="strugleStart()">Következő Küzdelem indítása</button>';
	}
	while($row =pg_fetch_row($strugleResult, NULL, PGSQL_ASSOC)){
		array_push($strugleArray,$row);
	}
	$body = "";
	foreach ( $strugleArray as $key =>$racer) {
		$raceName = DBLoad::loadUserWithoutActive($racer["ts_racer_id"]);
		$body.= "<tr>";
		$body.= "<td width='10px'>".($key+1)."</td>";
		$body.= "<td>".$raceName->getName()."</td>";
		$body.= "<td>".$racer["ts_racer_point"]."</td>";
		$body.= "</tr>";
	}
	echo json_encode(array($head,$body));
}