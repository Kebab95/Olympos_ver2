<?php
include "../../includeClasses.php";
session_start();
$DBTasks = new DBTasks();
if(isset($_POST["orgIDHidden"])){
	$orgID = $_POST["orgIDHidden"];

	if($DBTasks->joinClub($orgID,$_SESSION["User"]->getId())){

	}
	else {
		echo 2;
	}

}
else {
	echo 1;
}


