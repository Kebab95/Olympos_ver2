<?php

$db =0;
$fields = array();
for($i=1; $i<11; $i++){
	if(isset($_POST["compName".$i]) && isset($_POST["compType".$i]) && isset($_POST["compSex".$i])){
	//	echo "Hihi";
		$fields[$db] = array($_POST["compName".$i],$_POST["compType".$i],$_POST["compSex".$i],$_SESSION["User"]->getId());
		$db++;
	}
}
if(count($fields) == $_POST["compNumber"]){
	if($DBTasks->insertComp($fields)){

	}
	else {
		$error = true;
	}
}
else {
	$error = true;
}