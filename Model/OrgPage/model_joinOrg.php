<?php
include "../../includeClasses.php";
session_start();
$DBTasks = new DBTasks();
if(isset($_POST["orgIDHidden"])){
	$orgID = $_POST["orgIDHidden"];

	if($DBTasks->joinClub($orgID,$_SESSION["User"]->getId())){

	}
	else {
		echo "<script>alert('2')</script>";
	}

}
else {
	echo "<script>alert('1')</script>";
}


