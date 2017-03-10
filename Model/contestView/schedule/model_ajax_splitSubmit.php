<?php
include "../../../includeClasses.php";
$DBTasks = new DBTasks();
DBLoad::init();
for($i=0; $i<count($_POST["userIDs"]); $i++){
	$result2 =$DBTasks->sqlWithConn('Select
					  *
					From
					  contest.assignment Inner Join
					  contest.contest_comp
					    On contest.assignment.a_ccc_id = contest.contest_comp.ccc_id
					Where
						contest.contest_comp.ccc_comp_id='.$_POST["compID"].' AND
					  contest.contest_comp.ccc_cat_id = '.$_POST["catID"].' And
					  contest.contest_comp.ccc_division = '.$_POST["division"][$i]);
	$cccID =0;
	if(pg_num_rows($result2)==0){

	    $asd=$DBTasks->sqlWithConn('INSERT INTO contest.contest_comp
							(ccc_contest_id,
							ccc_comp_id,
							ccc_cat_id,
							ccc_division)
							VALUES
							('.$_POST["contestID"].',
							'.$_POST["compID"].',
							'.$_POST["catID"].',
							'.$_POST["division"][$i].')
							RETURNING ccc_id');
		$cccID =pg_fetch_row($asd, NULL, PGSQL_ASSOC)["ccc_id"];
	}
	else {
		$cccID =pg_fetch_row($result2, NULL, PGSQL_ASSOC)["ccc_id"];
	}
	$userIDres = $DBTasks->sqlWithConn('Select
			  contest.assignment.a_id
			From
			  contest.assignment Inner Join
			  contest.contest_comp
			    On contest.assignment.a_ccc_id = contest.contest_comp.ccc_id
			Where
			  contest.contest_comp.ccc_comp_id='.$_POST["compID"].' AND
				  contest.contest_comp.ccc_cat_id = '.$_POST["catID"].' And
				  contest.assignment.a_muid = '.$_POST["userIDs"][$i]);
	$aID =pg_fetch_row($userIDres, NULL, PGSQL_ASSOC)["a_id"];
	$DBTasks->sqlWithConn('UPDATE contest.assignment SET a_ccc_id='.$cccID.", a_lctime=NOW() WHERE a_id=".$aID);

}