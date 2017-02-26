<?php
include "../../includeClasses.php";
if(isset($_POST["weight"]) && isset($_POST["beltGradesID"]) && isset($_POST["memberID"])){
	$DBTasks = new DBTasks();

	if($_POST["upOrin"]=="1"){
		$asd = $DBTasks->update(DBData::getMemberDataTable(),DBData::$memberDataWeight."=".$_POST["weight"].","
				.DBData::$memberDataGradesBeltID."=".$_POST["beltGradesID"].", ".DBData::$memberDataLastChangeTime."=NOW()",
				DBData::$memberDataMuID."=".$_POST["memberID"]);
	}
	else if($_POST["upOrin"]=="0"){
		$asd = $DBTasks->insert(DBData::getMemberDataTable(),
				DBData::$memberDataMuID.",".DBData::$memberDataWeight.",".DBData::$memberDataGradesBeltID,
				$_POST["memberID"].",".$_POST["weight"].",".$_POST["beltGradesID"]);
	}

	if(isset($asd) && $asd){
		$User = masLoadUser($_POST["memberID"]);
		echo "<td>".$User->getName()."</td>";
		echo "<td>".$User->getWeight()."</td>";
		echo "<td>".$User->getBeltGrades()."</td>";
		echo "<td>".$User->getAge()."</td>";
		echo "<td><button onclick='sportDataUpdate(".$User->getId().")' class='btn btn-info2 btn-block'>Sport Adatok Frissítése</button></td>";
		if($User->getEmail()!=null){
			echo "<td><button class='btn btn-info btn-block' onclick='showModalProfile(".$_POST["updaterID"].",".$User->getId().")'>Profil</button> </td>";
		}
		else {
			echo "<td><input type='button' class='btn btn-info btn-block' value='Létrehozás'></td>";
		}
		if($_POST["isClubLeader"]){
			echo "<td><button class='btn btn-danger btn-block'>Tag törlése</button> </td>";
		}
	}
	else {
		echo "false";
	}
	//var_dump($asd);
}
else {
	echo "false";
}
function masLoadUser($id){
	$DBTasks = new DBTasks();
	$row = $DBTasks->select(DBData::getMainUserTable(),
			"*",
			DBData::$mainUserID." = ".$id ,
			"LEFT JOIN ".DBData::getEmailDataTable()." ON
                            ".DBData::getMainUserTable().".".DBData::$mainUserEmailID."=
                            ".DBData::getEmailDataTable().".".DBData::$emailDataID."
            LEFT JOIN ".DBData::getTelefonDataTable()." ON
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
