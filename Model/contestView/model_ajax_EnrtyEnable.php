<?php
include "../../includeClasses.php";
$DBTasks = new DBTasks();

//$contestID = $_GET["contestview"];
//

if(isset($_REQUEST['id']) )
{

	$value = $_REQUEST['id'];
	$result = $DBTasks->update(DBData::getContestTable(),DBData::$contestIsEntry."=true",DBData::$contestID."=".$value);
	if($result!=null || $result==true){
		echo true;
	}
	else {
		echo 0;
	}
//Your Insertion/Updation Databse Script
}
