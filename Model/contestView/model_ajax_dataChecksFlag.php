<?php
if(isset($_POST["contestID"]) && isset($_POST["flag"])){
	include "../../includeClasses.php";
	$DBTasks = new DBTasks();
	$DBTasks->update(DBData::getContestTable(),DBData::$contestDataChecks."=".$_POST["flag"].", lctime=NOW()",DBData::$contestID."=".$_POST["contestID"]);
}