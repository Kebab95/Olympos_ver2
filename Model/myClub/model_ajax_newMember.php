<?php
include "../../includeClasses.php";
$DBTasks = new DBTasks();
if($_POST){
	if(isset($_POST["memberEmail"]) && (strlen($_POST["memberEmail"])>0) && isset($_POST["memberName"] )&& isset($_POST["nem"])
			&& isset($_POST["memberBDate"]) && (strlen($_POST["memberBDate"])>0)){
		$emailExist = false;
		$result = $DBTasks->selectGetResult(DBData::getEmailDataTable(),
			DBData::$emailDataAdd,
			DBData::$emailDataAdd."=".$_POST["memberEmail"]);
		if(pg_num_rows($result) >0){
			echo 1;
		}
		else {
			echo insertNewMember($_POST["memberOrgId"],$_POST["memberName"],$_POST["memberBDate"],$_POST["nem"],$_POST["memberEmail"]);
		}
	}
	else if(isset($_POST["memberName"])){
		echo insertNewMember($_POST["memberOrgId"],$_POST["memberName"],$_POST["memberBDate"],$_POST["nem"]);
	}
	else {
		echo false;
	}
}
else {
	echo false;
}
function insertNewMember($orgId,$name,$bdate,$sex,$email = null){
	$DBTasks  = new DBTasks();
	echo $sql = "with ".($email!=null?"email as (
		select ".DBData::getEmailFunction($email)." as ed_d
	), ":"")."userInsert as (
		insert into ".DBData::getMainUserTable()."
			(".DBData::$mainUserName.
			($email!=null?",".DBData::$mainUserEmailID:"").",
			".DBData::$mainUserType.",
			".DBData::$mainUserActive.",
			".DBData::$mainUserBDate.")
			values
			('".$name."'".
			($email!=null?",(select ed_id from email)":"").",
			1,
			".($sex==1?"false":"true").",
			'".$bdate."') returning ".DBData::$mainUserID."
	), perm as (
	insert into ".DBData::getPermissionTable()." (
			".DBData::$permissionMainUserID."
			)
			values ((select ".DBData::$mainUserID." from userInsert)) returning ".DBData::$permissionMainUserID."
	)
	insert into ".DBData::getClubMemberHistoryTable()." (
					".DBData::$chClubID.",
					".DBData::$chMemberID.",
					".DBData::$chCurrent.")
				values (".$orgId.",
						(select ".DBData::$mainUserID." from userInsert),
						true);";

	$DBTasks->Connect();
	$result = $DBTasks->sql($sql);
	$DBTasks->ConnClose();
	if(pg_num_rows($result) >0){
		return true;
	}
	else {
		return false;
	}
}