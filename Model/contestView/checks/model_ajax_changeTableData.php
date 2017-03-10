<?php
include "../../../includeClasses.php";
$DBTasks = new DBTasks();
$DBTasks->Connect();
$result = $DBTasks->sql("Select
  contest.entry.en_compid,
  contest.entry.en_orgid,
  contest.entry.en_deliberation,
  data.main_user.mu_id,
  data.main_user.mu_name,
  data.main_user.mu_pass,
  data.main_user.mu_bdate,
  data.main_user.mu_active,
  data.email_data.ed_add,
  data.telefon_data.td_num,
  data.member_data.md_weight,
  data.main_user.mu_type,
  data.belt_grades_data.bgd_name,
  data.belt_grades_data.bgd_klevel_id,
  data.main_user.mu_sex
From
  contest.entry Inner Join
  data.main_user
    On contest.entry.en_muid = data.main_user.mu_id Left Join
  data.email_data
    On data.main_user.mu_email_id = data.email_data.ed_id Left Join
  data.telefon_data
    On data.main_user.mu_telefon_id = data.telefon_data.td_id Left Join
  data.member_data
    On data.member_data.md_muid = data.main_user.mu_id Inner Join
  data.belt_grades_data
    On data.member_data.md_beltgradesid = data.belt_grades_data.bgd_id
Where
  contest.entry.en_contest = ".$_POST["contestID"]." And
  contest.entry.en_orgid = ".$_POST["orgId"]."
Group By
  contest.entry.en_compid, contest.entry.en_orgid, data.main_user.mu_id,
  data.main_user.mu_name, data.main_user.mu_pass, data.main_user.mu_bdate,
  data.main_user.mu_active, data.email_data.ed_add, data.telefon_data.td_num,
  data.member_data.md_weight, data.main_user.mu_type,
  data.belt_grades_data.bgd_name,contest.entry.en_deliberation,
  data.belt_grades_data.bgd_klevel_id,
  data.main_user.mu_sex");
$DBTasks->ConnClose();
$User = array();
while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
	/** @var Competetion $value */
	$temp = SportUser::createWithDB($row);
	$User[$temp->getId()]["Deliberation"] = $row[DBData::$entryDeliberation]=="t";
	if(isset($User[$temp->getId()]) && isset($User[$temp->getId()]["User"])){
		$User[$temp->getId()][$row[DBData::$entryCompID]] = true;
	}
	else {
		$User[$temp->getId()]["User"] = $temp;
		foreach ($_POST["compIds"] as $value) {
			$User[$temp->getId()][$value] = false;
		}
		$User[$temp->getId()][$row[DBData::$entryCompID]] = true;
	}
}

foreach ($User as $item) {
	if($item["Deliberation"]){
		echo "<tr style='background-color: #3e8f3e'>";
		/** @var SportUser $tempUser */
		$tempUser = $item["User"];
		echo "<td>".$tempUser->getName()."</td>";
		echo "<td>".$tempUser->getWeight()."</td>";
		echo "<td>".$tempUser->getBeltGrades()."</td>";
		echo "<td>".$tempUser->getAge()."</td>";
		foreach ($_POST["compIds"] as $comp) {
			array_push($tempCompArray,$comp);
			echo "<td><input type='checkbox' disabled id='check".$comp.$tempUser->getId()."' ".($item[$comp]?"checked":"")."></td>";
			//echo "<td class='vertical-header'><div class='vertical-header'><strong>".$comp->getTitle()."</strong></div></td>";
		}
		echo "<td>";
		echo "<button type='button' class='btn btn-info2 btn-block'>Feloldás</button>";
		echo "</td>";
		echo "</tr>";
	}
	else {
		/** @var SportUser $tempUser */
		$tempUser = $item["User"];
		echo "<tr id='memberRow".$tempUser->getId()."'>";
		echo "<td>".$tempUser->getName()."</td>";
		echo "<td>";
		echo "<input type='number' class='form-control' id='memberWeight".$tempUser->getId()."' value='".$tempUser->getWeight()."'>";
		echo "<input type='hidden' id='defaultWeight".$tempUser->getId()."' value='".$tempUser->getWeight()."'>";
		echo "</td>";
		echo "<td>".$tempUser->getBeltGrades()."</td>";
		echo "<td>".$tempUser->getAge()."</td>";
		$tempCompArray = array();
		foreach ($_POST["compIds"] as $comp) {
			array_push($tempCompArray,$comp);
			echo "<td><input type='checkbox' id='check".$comp.$tempUser->getId()."' ".($item[$comp]?"checked":"")."></td>";
			//echo "<td class='vertical-header'><div class='vertical-header'><strong>".$comp->getTitle()."</strong></div></td>";
		}
		echo "<td>";
		$defaultVal = array();
		foreach ($tempCompArray as $value) {
			array_push($defaultVal,$item[$value]);
		}
		echo "<input type='hidden' id='memberOrgId".$tempUser->getId()."' value='".$_POST["orgId"]."'>";
		echo "<input type='hidden' id='defaultValue".$tempUser->getId()."' value='".json_encode($defaultVal)."'>";
		echo "<button type='button' onclick='entryFinalization(".$tempUser->getId().")' class='btn btn-success btn-block'>Véglegesítés</button>";
		echo "</td>";
		echo "</tr>";
	}

}

