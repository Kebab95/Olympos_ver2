<?php
if(isset($_POST["aID"]) && isset($_POST["updateType"])){
	include "../../../includeClasses.php";
	$DBTasks = new DBTasks();
	$DBTasks->Connect();
	$result = $DBTasks->sql('Select
		  *
		From
		  contest.assignment
		Where
		  contest.assignment.a_ccc_id In (Select
		    contest.assignment.a_ccc_id
		  From
		    contest.assignment
		  Where
		    contest.assignment.a_id = '.$_POST["aID"].')
		    ORDER BY a_seq');
	$DBTasks->ConnClose();
    if($_POST["updateType"]=="Up"){
	    $first = "";
	    $second = "";
	    while($row =pg_fetch_row($result, NULL, PGSQL_ASSOC)){
		    if($row["a_id"] == $_POST["aID"]){
				$first = $row;
			    break;
		    }
		    else{
			     $second = $row;
		    }
	    }
	   // var_dump($second);
		$DBTasks->Connect();
	    $DBTasks->sql('UPDATE contest.assignment SET a_seq='.$second["a_seq"].', a_lctime=NOW() WHERE a_id='.$first["a_id"]);
	    $DBTasks->ConnClose();
	    $DBTasks->Connect();
	    $DBTasks->sql('UPDATE contest.assignment SET a_seq='.$first["a_seq"].', a_lctime=NOW() WHERE a_id='.$second["a_id"]);
	    $DBTasks->ConnClose();
    }
	else if($_POST["updateType"] == "Down"){
		$bool = false;
		$first = "";
		$second = "";
		while($row =pg_fetch_row($result, NULL, PGSQL_ASSOC)){
			if($row["a_id"] == $_POST["aID"]){
				$first = $row;
				$bool = true;
			}
			else if($bool){
				$second = $row;
				break;
			}
		}
		$DBTasks->Connect();
		$DBTasks->sql('UPDATE contest.assignment SET a_seq='.$second["a_seq"].', a_lctime=NOW() WHERE a_id='.$first["a_id"]);
		$DBTasks->ConnClose();
		$DBTasks->Connect();
		$DBTasks->sql('UPDATE contest.assignment SET a_seq='.$first["a_seq"].', a_lctime=NOW() WHERE a_id='.$second["a_id"]);
		$DBTasks->ConnClose();
	}
	$DBTasks->Connect();
	$result = $DBTasks->sql('Select
  *
From
  contest.assignment Inner Join
  contest.contest_comp
    On contest.assignment.a_ccc_id = contest.contest_comp.ccc_id Inner Join
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
Where
  contest.contest_comp.ccc_id = '.$first["a_ccc_id"].'
  Order By
  contest.assignment.a_seq');
	$DBTasks->ConnClose();
	$tempArray = array();
	while($row =pg_fetch_row($result, NULL, PGSQL_ASSOC)){
		array_push($tempArray,$row);
	}
	$count = 0;
	foreach ($tempArray as $item) {
		if($item["a_id"] == $_POST["aID"]){
			$count++;
		}
	}
	$db = 1;
	foreach ($tempArray as $item) {
		$tempUser = SportUser::createWithDB($item);
		$tempOrg = DBLoad::loadOrg($item["a_orgid"]);
		echo "<tr>";
		echo "<td width='5%'>".$item["a_seq"]."</td>";
		echo "<td width='20%'><p onclick='showModalProfile(".$_POST["userID"].",".$tempUser->getId().")' '>".$tempUser->getName()."</p></td>";
		echo "<td width='20%'>".$tempUser->getAge()."</td>";
		echo "<td width='20%'>".$tempUser->getWeight()." kg</td>";
		echo "<td width='20%'>".$tempOrg->getName()."</td>";
		echo "<td width='5%'>".($db>1?"<span onclick='seqUp(".$item["a_id"].",\"".$_POST["rowID"]."\")' class='glyphicon glyphicon-triangle-top'></span>":"")."</td>";
		echo "<td width='5%'>".($db<count($tempArray)?"<span onclick='seqDown(".$item["a_id"].",\"".$_POST["rowID"]."\")' class='glyphicon glyphicon-triangle-bottom'></span>":"")."</td>";
		echo "<td width='15%'><button class='btn btn-block btn-default'>Nevezései</button> </td>";
		echo "</tr>";
		$db++;

	}
}

