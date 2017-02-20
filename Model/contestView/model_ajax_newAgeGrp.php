<?php
include "../../includeClasses.php";
$DBTasks = new DBTasks();
DBLoad::init();

//var_dump($_POST);

if(isset($_POST["min"]) && isset($_POST["max"]) && isset($_POST["org_id"]) && isset($_POST["type_id"])){
	$result = $DBTasks->insert(DBData::getAgeGroupTable(),
		DBData::$ageGrpMin.",".DBData::$ageGrpMax.",".DBData::$ageGrpOrgID.",".DBData::$ageGrpTypeID,
		$_POST["min"].",".$_POST["max"].",".$_POST["org_id"].",".$_POST["type_id"],"returning ".DBData::$ageGrpID);

	$row = pg_fetch_row($result, NULL, PGSQL_ASSOC);

	if(is_numeric($row[DBData::$ageGrpID])){
		$compPersonResult = $DBTasks->selectGetResult(DBData::getAgeGroupTable(),
				"*",DBData::$ageGrpTypeID."=".$_POST["type_id"]. " AND ".DBData::$ageGrpDelete."=false");
		if(pg_num_rows($compPersonResult)>0){
			$compPerson= array();
			while($row = pg_fetch_row($compPersonResult, NULL, PGSQL_ASSOC)){
				$compPerson[$_POST["comp_id"]][$row[DBData::$ageGrpID]] = $row;
			}
			echo json_encode($compPerson);
			//var_dump($compTypes);
		}
	}
	else {
		echo false;
	}
}

