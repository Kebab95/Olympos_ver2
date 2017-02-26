<?php
//var_dump($_POST);

if(isset($_POST["id"]) && (strlen($_POST["weight"])>0) && isset($_POST["beltgradesID"])){
	include "../../../includeClasses.php";
	$DBTasks = new DBTasks();
	DBLoad::init();


	$result = $DBTasks->insert(DBData::getMemberDataTable(),
		DBData::$memberDataMuID.",".DBData::$memberDataWeight.",".DBData::$memberDataGradesBeltID,
		$_POST["id"].",".$_POST["weight"].",".$_POST["beltgradesID"],"returning *");
	if(pg_num_rows($result)>0){
		$row = pg_fetch_row($result, NULL, PGSQL_ASSOC);
		$user = masLoadUser($row[DBData::$memberDataMuID]);
		echo "<td><a onclick='showModalProfile(0,".$user->getId().")'>".$user->getName()."</a></td>";
		echo "<td>".$user->getWeight()."</td>";
		echo "<td>".$user->getWeight()."</td>";
		echo "<td><label>Ki választ</label>
					<input type='checkbox' id='check".$user->getId()."'></td>";
		//echo json_encode($row);
	}
	else {
		echo "false";
	}
}
else {
	echo "false";
}
function masLoadUser($id){
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