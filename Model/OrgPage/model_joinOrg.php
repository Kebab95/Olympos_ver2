<?php
include "../../includeClasses.php";
session_start();
$DBTasks = new DBTasks();
if(isset($_POST["orgIDHidden"])){
	$orgID = $_POST["orgIDHidden"];

	if($_POST["orgID"]!=""){
		if($DBTasks->joinFed($orgID,$_POST["orgID"])){

		}
		else {
			echo 2;
		}
	}
	else {
		if($DBTasks->joinClub($orgID,$_SESSION["User"]->getId())){

		}
		else {
			echo 2;
		}
	}


}
else {
	echo 1;
}


