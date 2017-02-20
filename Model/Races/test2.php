<?php
include "../../includeClasses.php";
$DBTasks = new DBTasks();
$a = json_decode($_POST["createRaceHidden"],true);
$b = json_decode(json_encode($_POST),true);

$compData = array();
foreach ($b as $key => $value) {
	for($i=1; $i<11; $i++){
		if(strcmp($key,"compName".$i)==0){

		}
	}

}

echo json_encode($b);
//echo $DBTasks->createRace($a,$b);