<?php
include "../../includeClasses.php";
$DBTasks = new DBTasks();
DBLoad::init();

//var_dump($_POST);

if(isset($_POST["org_id"]) && isset($_POST["type_id"])){
	
	if($_POST["personalType"] =="0"){
		$result = $DBTasks->insert(DBData::getPersonalGroupTable(),
				DBData::$personalGrpTitle.",".DBData::$personalGrpCompID.",".DBData::$personalGrpTypeID.",".DBData::$personalGrpWeightMin.",".DBData::$personalGrpWeightMax,
				"'".$_POST["personalNum"][0]."-".$_POST["personalNum"][1]."',
				".$_POST["comp_id"].",
				".$_POST["type_id"].",
				".$_POST["personalNum"][0].",
				".$_POST["personalNum"][1],"returning ".DBData::$personalGrpID);
	}
	else if($_POST["personalType"] =="1"){
		$result = $DBTasks->insert(DBData::getPersonalGroupTable(),
				DBData::$personalGrpTitle.",".DBData::$personalGrpCompID.",".DBData::$personalGrpTypeID.",".DBData::$personalGrpknowLEdgeID,
				"'".$_POST["personalNum"][1]."',
				".$_POST["comp_id"].",
				".$_POST["type_id"].",
				".$_POST["personalNum"][0],"returning ".DBData::$personalGrpID);
	}

	$row = pg_fetch_row($result, NULL, PGSQL_ASSOC);

	if(is_numeric($row[DBData::$personalGrpID])){
		$compPersonResult = $DBTasks->selectGetResult(DBData::getPersonalGroupTable(),
				"*",DBData::$personalGrpCompID."=".$_POST["comp_id"]. " AND ".DBData::$personalGrpDelete."=false");
		if(pg_num_rows($compPersonResult)>0){
			$compPerson= array();
			while($row = pg_fetch_row($compPersonResult, NULL, PGSQL_ASSOC)){
				$compPerson[$_POST["comp_id"]][$row[DBData::$personalGrpID]] = $row;
			}
			echo json_encode($compPerson);
			//var_dump($compTypes);
		}
	}
	else {
		echo false;
	}
}

