<?php
include "../../includeClasses.php";
$DBTasks = new DBTasks();
DBLoad::init();

//var_dump($_POST);

if(isset($_POST["title"]) && isset($_POST["org_id"]) && isset($_POST["type_id"])){
	$result = $DBTasks->insert(DBData::getPersonalGroupTable(),
		DBData::$personalGrpTitle.",".DBData::$personalGrpOrgID.",".DBData::$personalGrpTypeID,
		"'".$_POST["title"]."',".$_POST["org_id"].",".$_POST["type_id"],"returning ".DBData::$personalGrpID);

	$row = pg_fetch_row($result, NULL, PGSQL_ASSOC);

	if(is_numeric($row[DBData::$personalGrpID])){
		$compPersonResult = $DBTasks->selectGetResult(DBData::getPersonalGroupTable(),
				"*",DBData::$personalGrpTypeID."=".$_POST["type_id"]. " AND ".DBData::$personalGrpDelete."=false");
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

