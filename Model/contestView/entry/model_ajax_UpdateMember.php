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
		echo "<td>";
		$user = DBLoad::loadUser($row[DBData::$memberDataMuID]);
		echo $user->getName();
		echo "</td>";
		echo "<td>".$row[DBData::$memberDataWeight]."</td>";
		$result = $DBTasks->selectGetResult(DBData::getBeltGradesDataTable(),"*",DBData::$beltGradesID."=".$row[DBData::$memberDataGradesBeltID]);
		$row2 = pg_fetch_row($result, NULL, PGSQL_ASSOC);
		echo "<td>".$row2[DBData::$beltGradesName]."</td>";
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