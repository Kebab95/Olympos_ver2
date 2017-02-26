<?php

//var_dump($_POST);
if((isset($_POST["compIDs"]) &&
	isset($_POST["compChecks"]) &&
	isset($_POST["memberId"]) &&
	isset($_POST["defaultVal"]) &&
	isset($_POST["memberWeight"]) &&
	isset($_POST["defaultWeight"])) &&
	(strlen($_POST["memberId"])>0 &&
			$_POST["memberWeight"]>0 &&
			$_POST["memberWeight"]>0)){

	include "../../../includeClasses.php";
	$DBTasks = new DBTasks();
	DBLoad::init();

	if(strcmp($_POST["defaultWeight"],$_POST["memberWeight"])!=0){
		$DBTasks->update(DBData::getMemberDataTable(),
				DBData::$memberDataWeight."=".$_POST["memberWeight"].",
				".DBData::$memberDataLastChangeTime."=NOW()",
				DBData::$memberDataMuID."=".$_POST["memberId"]);
	}
	$DBTasks->Connect();
	for($i=0; $i<count($_POST["compIDs"]); $i++){

		$defaultCheck = $_POST["defaultVal"][$i]=="true";
		$userCheck = $_POST["compChecks"][$i]=="true";
		if($userCheck){
		    if($defaultCheck != $userCheck){

			    $DBTasks->sql('SELECT contest.datachecks_update_insert(
						    '.$_POST["memberId"].',
						    '.$_POST["orgId"].',
						    '.$_POST["compIDs"][$i].',
						    '.$_POST["contestID"].',
						    true,
						    true,
						    true,
						    true)');

		    }
			else {
				//echo "Maradt becsekkelve";
				$DBTasks->sql('SELECT contest.datachecks_update_insert(
						    '.$_POST["memberId"].',
						    '.$_POST["orgId"].',
						    '.$_POST["compIDs"][$i].',
						    '.$_POST["contestID"].',
						    true,
						    true,
						    true,
						    true)');
			}
		}
		else {
			//Ez akkor fog lefutni ha egy true chekbox false-ra változott
			if($defaultCheck != $userCheck){
				//echo "Kicsekkelte";
				$DBTasks->sql('SELECT contest.datachecks_update_insert(
						    '.$_POST["memberId"].',
						    '.$_POST["orgId"].',
						    '.$_POST["compIDs"][$i].',
						    '.$_POST["contestID"].',
						    false,
						    false,
						    false,
						    false)');
			}
		}
	}
	$DBTasks->ConnClose();
	$User = newLoadUser($_POST["memberId"]);
	echo "<td>".$User->getName()."</td>";
	echo "<td>".$User->getWeight()."</td>";
	echo "<td>".$User->getBeltGrades()."</td>";
	echo "<td>".$User->getAge()."</td>";
	for($i=0; $i<count($_POST["compIDs"]); $i++){
		echo "<td><input type='checkbox' disabled id='check".$_POST["compIDs"][$i].$User->getId()."' ".($_POST["compChecks"][$i]?"checked":"")."></td>";
	}
	echo "<td>";
	echo "<button type='button' class='btn btn-info2 btn-block'>Feloldás</button>";
	echo "</td>";
}
else {

}
function newLoadUser($id){
	$DBTasks = new DBTasks();
	$row = $DBTasks->select(DBData::getMainUserTable(),
			"*",
			DBData::$mainUserID." = ".$id ,
			"Left JOIN ".DBData::getEmailDataTable()." ON
                            ".DBData::getMainUserTable().".".DBData::$mainUserEmailID."=
                            ".DBData::getEmailDataTable().".".DBData::$emailDataID."
            Left JOIN ".DBData::getTelefonDataTable()." ON
                            ".DBData::getMainUserTable().".".DBData::$mainUserTelefonID."=
                            ".DBData::getTelefonDataTable().".".DBData::$telefonDataID."
            Left Join
				  data.member_data
				    On data.member_data.md_muid = data.main_user.mu_id Left Join
				  data.belt_grades_data
				    On data.member_data.md_beltgradesid = data.belt_grades_data.bgd_id");
	if($row){
		if(isset($row[DBData::$memberDataID])){
			$user = SportUser::createWithDB($row);
		}
		else {
			$user = User::createWithDB($row);
		}

		$user =$DBTasks->refreshUserPermission($user);
		return $user;
	}
	else {
		return null;
	}
}
