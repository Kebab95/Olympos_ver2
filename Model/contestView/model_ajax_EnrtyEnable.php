<?php
include "../../includeClasses.php";
$DBTasks = new DBTasks();

//$contestID = $_GET["contestview"];
//

if(isset($_REQUEST['id']) )
{

	$value = $_REQUEST['id'];
	$comp = $DBTasks->selectGetResult(DBData::getConnectionCCCTable(),DBData::$connCCC_CompID,
			DBData::$connCCC_ContestID."=".$value,null,"GROUP BY ".DBData::$connCCC_CompID);
	if(pg_num_rows($comp)>0){
		$result = $DBTasks->update(DBData::getContestTable(),DBData::$contestIsEntry."=true",DBData::$contestID."=".$value);
		if($result!=null || $result==true){
			echo true;
		}
		else {
			echo 0;
		}
	}
	else {
		echo 1;
	}

//Your Insertion/Updation Databse Script
}
