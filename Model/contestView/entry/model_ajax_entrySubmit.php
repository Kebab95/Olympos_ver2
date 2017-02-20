<?php
include "../../../includeClasses.php";
$DBTasks = new DBTasks();
if(isset($_POST["memberID"])){
	$insert = "";
	$error = false;
    for($i=0; $i<count($_POST["memberID"]); $i++){
		if(isset($_POST["selectComp".$_POST["memberID"][$i]])){
			foreach ($_POST["selectComp".$_POST["memberID"][$i]] as $compID) {
				if(strlen($insert)>0){
				    $insert.=",";
				}
				$insert.="(".$_POST["memberID"][$i].",
							".$_POST["clubID"].",
							".$compID.",
							".$_POST["contestID"].")";
			}
		}
	    else{
		    $error=  true;
		    break;
	    }
    }
	if(!$error){
		$sql = "INSERT INTO ".DBData::getEntryTable()." (".DBData::$entryMuID.",".
			DBData::$entryorgID.",".
			DBData::$entryCompID.",".
			DBData::$entryContestID.") VALUES ".$insert;
	    $DBTasks->Connect();
		$result = $DBTasks->sql($sql);
		$DBTasks->ConnClose();
		echo "siker";
	}
	else {
		echo "false";
	}
}
else {
	echo "false";
}