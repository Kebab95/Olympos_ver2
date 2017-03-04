<?php
$DBTasks->Connect();
$orgResult = $DBTasks->sql('Select
  contest.entry.en_orgid,
  data.main_user.mu_name
From
  contest.entry Inner Join
  data.main_user
    On contest.entry.en_orgid = data.main_user.mu_id
Where
  contest.entry.en_contest = '.$_GET["contestview"].'
Group By
  contest.entry.en_contest, contest.entry.en_orgid, data.main_user.mu_name');
$orgArray = array();
while($row = pg_fetch_row($orgResult, NULL, PGSQL_ASSOC)){
	array_push($orgArray,$row);
}
//var_dump($orgArray);
$result = $DBTasks->sql("Select
  contest.entry.en_compid,
  contest.entry.en_orgid,
  contest.entry.en_deliberation,
  data.main_user.mu_id,
  data.main_user.mu_name,
  data.main_user.mu_pass,
  data.main_user.mu_bdate,
  data.main_user.mu_active,
  data.email_data.ed_add,
  data.telefon_data.td_num,
  data.member_data.md_weight,
  data.main_user.mu_type,
  data.belt_grades_data.bgd_name,
  data.belt_grades_data.bgd_klevel_id
From
  contest.entry Inner Join
  data.main_user
    On contest.entry.en_muid = data.main_user.mu_id Left Join
  data.email_data
    On data.main_user.mu_email_id = data.email_data.ed_id Left Join
  data.telefon_data
    On data.main_user.mu_telefon_id = data.telefon_data.td_id Left Join
  data.member_data
    On data.member_data.md_muid = data.main_user.mu_id Inner Join
  data.belt_grades_data
    On data.member_data.md_beltgradesid = data.belt_grades_data.bgd_id
Where
  contest.entry.en_contest = ".$_GET["contestview"]." And
  contest.entry.en_orgid = ".$orgArray[0][DBData::$entryorgID]."
Group By
  contest.entry.en_compid, contest.entry.en_orgid, data.main_user.mu_id,

  contest.entry.en_deliberation,
  data.main_user.mu_name, data.main_user.mu_pass, data.main_user.mu_bdate,
  data.main_user.mu_active, data.email_data.ed_add, data.telefon_data.td_num,
  data.member_data.md_weight, data.main_user.mu_type,
  data.belt_grades_data.bgd_name,
  data.belt_grades_data.bgd_klevel_id");

$Compresult = $DBTasks->sql("Select
  contest.competetions.comp_id,
  contest.competetions.comp_title,
  contest.comp_types.comp_types_id,
  contest.comp_types.comp_types_name,
  contest.comp_types.comp_types_mu_id,
  contest.comp_types.comp_types_fighting_event,
  contest.comp_types.comp_types_technical_event,
  contest.comp_types.comp_types_group_event,
  contest.competetions.mu_id
From
  contest.competetions Inner Join
  contest.contest_comp
    On contest.contest_comp.ccc_comp_id = contest.competetions.comp_id
  Inner Join
  contest.comp_types
    On contest.competetions.type_id = contest.comp_types.comp_types_id
Where
  contest.contest_comp.ccc_contest_id = ".$_GET["contestview"]."
Group By
  contest.competetions.comp_id, contest.competetions.comp_title,
  contest.comp_types.comp_types_id, contest.comp_types.comp_types_name,
  contest.comp_types.comp_types_mu_id,
  contest.comp_types.comp_types_fighting_event,
  contest.comp_types.comp_types_technical_event,
  contest.comp_types.comp_types_group_event, contest.competetions.mu_id");
$DBTasks->ConnClose();
$CompArray = array();
while($row = pg_fetch_row($Compresult, NULL, PGSQL_ASSOC)){
	array_push($CompArray,Competetion::createWithDB($row));
}
$User = array();
while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
	/** @var Competetion $value */
	$temp = SportUser::createWithDB($row);
	$User[$temp->getId()]["Deliberation"] = $row[DBData::$entryDeliberation]=="t";
	if(isset($User[$temp->getId()]) && isset($User[$temp->getId()]["User"])){
		$User[$temp->getId()][$row[DBData::$entryCompID]] = true;
	}
	else {
		$User[$temp->getId()]["User"] = $temp;
		foreach ($CompArray as $value) {
			$User[$temp->getId()][$value->getId()] = false;
		}
		$User[$temp->getId()][$row[DBData::$entryCompID]] = true;
	}


}