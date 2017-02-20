<?php
include "../../includeClasses.php";
session_start();
$DBTasks = new DBTasks();
$_POST[DBData::$contestDate] = date('Y-m-d H:i:s',strtotime($_POST[DBData::$contestDate]));
$result = $DBTasks->createRace($_POST);
if(is_bool($result) && !$result){
	echo $result;
}
