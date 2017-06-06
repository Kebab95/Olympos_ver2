<?php
include "../../../includeClasses.php";
$DBTasks = new DBTasks();
$sql = 'Select
  Count(contest.assignment.a_muid) As user_count,
  contest.contest_comp.ccc_cat_id,
  contest.contest_comp.ccc_comp_id,
  contest.contest_comp.ccc_division,
  contest.contest_comp.ccc_id,
  contest.comp_types.comp_types_fighting_event,
  contest.comp_types.comp_types_technical_event,
  contest.comp_types.comp_types_group_event
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
  contest.contest_comp.ccc_contest_id = '.$_POST["contestID"].'
Group By
  contest.contest_comp.ccc_cat_id, contest.contest_comp.ccc_comp_id,
  contest.contest_comp.ccc_division, contest.contest_comp.ccc_id,
  contest.comp_types.comp_types_fighting_event,
  contest.comp_types.comp_types_technical_event,
  contest.comp_types.comp_types_group_event';
$userArrayRes = $DBTasks->sqlWithConn($sql);
$error = false;

while($row =pg_fetch_row($userArrayRes, NULL, PGSQL_ASSOC)){
	if($row[DBData::getCompTypesFlag(0)] =="t"){
		$strugleResult = $DBTasks->sqlWithConn('Select
			  *
			From
			  contest_data.strugle_data Inner Join
			  contest.contest_comp
			    On contest_data.strugle_data.s_ccc_id = contest.contest_comp.ccc_id
			    Where
			  contest.contest_comp.ccc_id = '.$row[DBData::$connCCC_Id].'
			  Order By
			  contest_data.strugle_data.s_ctime');
		$tempstrugleArray = array();
		if(pg_num_rows($strugleResult)>0){
			while($asd =pg_fetch_row($strugleResult, NULL, PGSQL_ASSOC)){
				array_push($tempstrugleArray,$asd);
			}
		}
		switch($row["user_count"]){
			case 2:
				if(count($tempstrugleArray)!=1){
					$error=true;
				}
				break;
			case 3:
				if(count($tempstrugleArray)!=3){
					$error=true;
				}
				break;
			case 4:
				if(count($tempstrugleArray)!=3){
					$error=true;
				}
				break;
			case 8:
				if(count($tempstrugleArray)!=7){
					$error = true;
				}
				break;
		}
	}
	else if($row[DBData::getCompTypesFlag(1)]=="t"){
		$strugleResult = $DBTasks->sqlWithConn('Select
			  *
			From
			  contest_data.technical_strugle_data Inner Join
			  contest.contest_comp
			    On contest_data.technical_strugle_data.ts_ccc_id = contest.contest_comp.ccc_id
			    Where
			  contest.contest_comp.ccc_id = '.$row[DBData::$connCCC_Id].' AND
  contest_data.technical_strugle_data.ts_use = True
			  Order By
			  contest_data.technical_strugle_data.ts_ctime');
		$tempstrugleArray = array();
		if(pg_num_rows($strugleResult)>0){
			while($asd =pg_fetch_row($strugleResult, NULL, PGSQL_ASSOC)){
				array_push($tempstrugleArray,$asd);
			}
		}
		if($row["user_count"]!=count($tempstrugleArray)){
			$error=true;
		}
	}


}
if($error){
    echo 0;
}
else {
	$update = $DBTasks->sqlWithConn('UPDATE contest.contest SET lctime=NOW(),contest_closed=TRUE WHERE contest_id='.$_POST["contestID"]);
	if($update){
	    echo 2;
	}
	else{
		echo 1;
	}
}