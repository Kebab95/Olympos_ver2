<?php
if(isset($_POST["typeName"]) && isset($_POST["typeEventNum"]) && isset($_POST["orgID"])){
	include "../../includeClasses.php";
	$DBTasks = new DBTasks();
	$DBTasks->insert(DBData::getContestCompTypesTable(),
		DBData::$contestCompTypesName.",
		".DBData::$contestCompTypesMuID.",
		".DBData::getCompTypesFlag($_POST["typeEventNum"]),

		"'".$_POST["typeName"]."',
		".$_POST["orgID"].",
		true");
	$resultTypes = $DBTasks->selectGetResult(DBData::getContestCompTypesTable(),
		"*",
		DBData::$compTypesMUid."=".$_POST["orgID"]." AND ".DBData::$compTypesDelete." = false");
	if(pg_num_rows($resultTypes)>0){
		$compTypesArray =array();
		while($row = pg_fetch_row($resultTypes, NULL, PGSQL_ASSOC)){
			array_push($compTypesArray,CompTypes::createWithDB($row));
		}


	}
	/** @var CompTypes $types */
	foreach ($compTypesArray as $types) {
		if($types->getEvents(DBData::getCompTypesFlag(0))){
			$event ="Küzdelmi";
		}
		else if($types->getEvents(DBData::getCompTypesFlag(1))){
			$event ="Technikai";
		}
		else {
			$event ="Nincs";
		}
		echo "<option value='".$types->getId()."'>".$types->getName()." (".$event.")</option>";
	}
}