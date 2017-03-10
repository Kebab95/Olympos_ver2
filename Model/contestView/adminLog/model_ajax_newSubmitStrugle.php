<?php
include "../../../includeClasses.php";
$DBTasks = new DBTasks();
DBLoad::init();
$DBTasks->sqlWithConn('INSERT INTO contest_data.strugle_data(
					s_racer_1,
					s_racer_2,
					s_racer_1_point,
					s_racer_2_point,
					s_winner_id,
					s_circle,
					s_log,
					s_lose_outcome_id,
					s_ccc_id
) VALUES
					('.$_POST["racer1ID"].',
					 '.$_POST["racer2ID"].',
					 '.$_POST["race1Point"].',
					 '.$_POST["race2Point"].',
					 '.$_POST["winnerID"].',
					 '.$_POST["circle"].',
					 \''.$_POST["log"].'\',
					 '.$_POST["loseCome"].',
					 '.$_POST["cccID"].'
					)');

$strugleResult = $DBTasks->sqlWithConn('Select
  *
From
  contest_data.strugle_data Inner Join
  contest.contest_comp
    On contest_data.strugle_data.s_ccc_id = contest.contest_comp.ccc_id
    Where
  contest.contest_comp.ccc_id = '.$_POST["cccID"].'
  Order By
  contest_data.strugle_data.s_ctime');

$strugleArray = array();
if(pg_num_rows($strugleResult)>0){
	while($row =pg_fetch_row($strugleResult, NULL, PGSQL_ASSOC)){
		array_push($strugleArray,$row);
	}
}

if(count($strugleArray)>0){
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
	$ossz =pg_fetch_row($userResult, NULL, PGSQL_ASSOC);
	$switch = false;
	$head = "";
	switch($ossz["ossz"]){
		case "2":
			if(count($strugleArray)==1){
				$switch=true;
			}
			break;
		case "3":
			if(count($strugleArray)==3){
				$switch=true;
			}
			break;
		default:
			if((count($strugleArray))-1==count($userArray)){
				$switch=true;
			}
	}
	if($switch){
		$head.= "Nincs több a küzdelemn";
	}
	else {
		$head.= '<button class="btn btn-success btn-block" id="strugleStart" onclick="strugleStart()">Következő Küzdelem indítása</button>';
	}
	while($row =pg_fetch_row($strugleResult, NULL, PGSQL_ASSOC)){
		array_push($strugleArray,$row);
	}
	$body = "";
	foreach ( $strugleArray as $key =>$racer) {
		$race1Name = DBLoad::loadUserWithoutActive($racer["s_racer_1"]);
		$race2Name = DBLoad::loadUserWithoutActive($racer["s_racer_2"]);
		$body.= "<tr>";
		$body.= "<td width='10px'>".($key+1)."</td>";
		$body.= "<td class='alert-danger' style='color: white;'>".$race1Name->getName()."</td>";
		$body.= "<td>".$racer["s_racer_1_point"]."</td>";
		$body.= "<td style=\"background-color: #002a80;color: white;\">".$race2Name->getName()."</td>";
		$body.= "<td>".$racer["s_racer_2_point"]."</td>";
		$body.= "<td ".($racer["s_winner_id"]==$race1Name->getId()?"class='alert-danger' style='color: white;'":"style=\"background-color: #002a80;color: white;\"").">".($racer["s_winner_id"]==$race1Name->getId()?$race1Name->getName():$race2Name->getName())."</td>";
		$body.= "<td>".$racer["s_circle"].". Forduló</td>";
		$body.= "</tr>";
	}
	echo json_encode(array($head,$body));
}