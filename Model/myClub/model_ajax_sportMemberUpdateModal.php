<?php
include "../../includeClasses.php";
$DBTasks = new DBTasks();
$result = $DBTasks->selectGetResult(DBData::getMemberDataTable(),"*",
				DBData::$memberDataMuID."=".$_POST["memberID"]." LIMIT 1","
				Inner Join
  data.belt_grades_data
    On data.member_data.md_beltgradesid = data.belt_grades_data.bgd_id");

echo "<div class='modal fade' id='sportUserUpdateModal'>";
echo "<div class='modal-dialog'>";
echo "<div class='modal-content'>";
echo "<div class='modal-header'>";
echo "Sport Tag verseny adatok frissítése";
echo "</div>";
echo "<div class='modal-body'>";
if(pg_num_rows($result)){
	$row = pg_fetch_row($result, NULL, PGSQL_ASSOC);
	$beltResult = $DBTasks->selectGetResult(DBData::getBeltGradesDataTable(),"*",DBData::$beltGradesWeight.">=".$row[DBData::$beltGradesWeight]." ORDER BY ".DBData::$beltGradesWeight);
	echo "<div class='row center-block text-center'>";
	echo "<div class='col-xs-6'>";
	echo "Súly (Kg)";
	echo "</div>";
	echo "<div class='col-xs-6'>";
	echo "<input class='form-control' type='number' id='sportUserWeight' value='".$row[DBData::$memberDataWeight]."'>";
	echo "</div>";
	echo "<div class='col-xs-6'>";
	echo "Öv fokozat";
	echo "</div>";
	echo "<div class='col-xs-6'>";
	echo "<select class='form-control' id='sportUserBeltID'>";
	while($gradesRow = pg_fetch_row($beltResult, NULL, PGSQL_ASSOC)){
		echo "<option value='".$gradesRow[DBData::$beltGradesID]."' ".($gradesRow[DBData::$beltGradesID]==$row[DBData::$beltGradesID]?"selected":"").">".$gradesRow[DBData::$beltGradesName]."</option>";
	}
	echo "</select>";
	echo "</div>";
	echo "<div class='col-xs-12'>";
	echo "<input type='hidden' value='1' id='insertOrUpdateSportMember'>";
	echo "<button class='btn btn-success btn-block' type='button' id='sportUserSubmit'>Frissítés</button>";
	echo "</div>";
	echo "</div>";

}
else {
	$beltResult = $DBTasks->selectGetResult(DBData::getBeltGradesDataTable(),"*",DBData::$beltGradesWeight.">=0 ORDER BY ".DBData::$beltGradesWeight);
	echo "<div class='row center-block text-center'>";
	echo "<div class='col-xs-6'>";
	echo "Súly (Kg)";
	echo "</div>";
	echo "<div class='col-xs-6'>";
	echo "<input class='form-control' type='number' id='sportUserWeight' value=''>";
	echo "</div>";
	echo "<div class='col-xs-6'>";
	echo "Öv fokozat";
	echo "</div>";
	echo "<div class='col-xs-6'>";
	echo "<select class='form-control' id='sportUserBeltID'>";
	while($gradesRow = pg_fetch_row($beltResult, NULL, PGSQL_ASSOC)){
		echo "<option value='".$gradesRow[DBData::$beltGradesID]."' >".$gradesRow[DBData::$beltGradesName]."</option>";
	}
	echo "</select>";
	echo "</div>";
	echo "<div class='col-xs-12'>";
	echo "<input type='hidden' value='0' id='insertOrUpdateSportMember'>";
	echo "<button class='btn btn-success btn-block' type='button' id='sportUserSubmit'>Frissítés</button>";
	echo "</div>";
	echo "</div>";
}

echo "</div>";
echo "<div class='modal-footer'>";
echo "<button type=\"button\" class=\"btn btn-default\" id='sportUserUpdateModalClose'>Close</button>";
echo "</div>";
echo "</div>";
echo "</div>";
echo "</div>";