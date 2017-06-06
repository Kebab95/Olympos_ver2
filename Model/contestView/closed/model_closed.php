<?php
$DBTasks->Connect();
$Compresult = $DBTasks->sql("Select
  contest.competetions.comp_id,
  contest.competetions.comp_title,
  contest.comp_types.comp_types_name,
  contest.comp_types.comp_types_id,
  contest.comp_types.comp_types_fighting_event,
  contest.comp_types.comp_types_technical_event,
  contest.comp_types.comp_types_group_event,
  contest.competetions.mu_id,
  contest.comp_types.comp_types_mu_id
From
  contest.assignment Inner Join
  contest.contest_comp
    On contest.assignment.a_ccc_id = contest.contest_comp.ccc_id Inner Join
  contest.competetions
    On contest.contest_comp.ccc_comp_id = contest.competetions.comp_id
  Inner Join
  contest.comp_types
    On contest.competetions.type_id = contest.comp_types.comp_types_id
Where
  contest.contest_comp.ccc_contest_id = ".$_GET["contestview"]."
Group By
  contest.competetions.comp_id, contest.competetions.comp_title,
  contest.comp_types.comp_types_name, contest.comp_types.comp_types_id,
  contest.comp_types.comp_types_fighting_event,
  contest.comp_types.comp_types_technical_event,
  contest.comp_types.comp_types_group_event, contest.competetions.mu_id,
  contest.comp_types.comp_types_mu_id");
$DBTasks->ConnClose();
$CompArray = array();
while($row = pg_fetch_row($Compresult, NULL, PGSQL_ASSOC)){
	array_push($CompArray,Competetion::createWithDB($row));
}
/*
$DBTasks->sqlWithConn('Select
  Count(contest.assignment.a_muid) As user_count,
  contest.contest_comp.ccc_cat_id,
  contest.contest_comp.ccc_comp_id
From
  contest.assignment Inner Join
  contest.contest_comp
    On contest.assignment.a_ccc_id = contest.contest_comp.ccc_id Inner Join
  contest.competetions
    On contest.contest_comp.ccc_comp_id = contest.competetions.comp_id
  Inner Join
  contest.comp_types
    On contest.competetions.type_id = contest.comp_types.comp_types_id
Where
  contest.contest_comp.ccc_contest_id = 124 And
  contest.comp_types.comp_types_fighting_event = True
Group By
  contest.contest_comp.ccc_cat_id, contest.competetions.type_id,
  contest.comp_types.comp_types_fighting_event, contest.contest_comp.ccc_comp_id');
*/