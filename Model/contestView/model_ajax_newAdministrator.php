<?php
include "../../includeClasses.php";
$DBTasks = new DBTasks();
$DBTasks->insert(DBData::getAdministratorTable(),DBData::$adminName.",".DBData::$adminGenCode.",".DBData::$adminConrestID,"'".$_POST["name"]."','".$_POST["genCode"]."',".$_POST["contestID"]);

$administratorResult = $DBTasks->selectGetResult(DBData::getAdministratorTable(),DBData::$adminName.",".DBData::$adminID.",".DBData::$adminGenCode,DBData::$adminConrestID."=".$_POST["contestID"]);
$administratorArray = array();
while($row = pg_fetch_row($administratorResult, NULL, PGSQL_ASSOC)){
	array_push($administratorArray,$row);
}
if(count($administratorArray)>0){
	foreach ($administratorArray as $admin) {
		echo "<p>".$admin[DBData::$adminName]." - ".$admin[DBData::$adminGenCode]."</p>";
	}
	echo "<hr>";
}