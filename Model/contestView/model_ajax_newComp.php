<?php
include "../../includeClasses.php";
$DBTasks = new DBTasks();
if(isset($_POST["compName"]) && isset($_POST["comTypeID"]) && isset($_POST["orgID"]) && isset($_POST["contestID"])){
	$fields[0][DBData::$competetionsTitle] = $_POST["compName"];
	$fields[0][DBData::$competetionsTypeID] = $_POST["comTypeID"];
	$fields[0][DBData::$competetionsMuID] = $_POST["orgID"];
	echo $DBTasks->insertCompAndConnectToCCC($fields,$_POST["contestID"]);
}
else {
	echo false;
}