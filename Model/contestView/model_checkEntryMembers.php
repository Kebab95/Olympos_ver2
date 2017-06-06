<?php
include "../../includeClasses.php";
$DBTasks = new DBTasks();
$result = $DBTasks->selectGetResult(DBData::getEntryTable(),"
data.main_user.mu_name,
data.main_user.mu_bdate,
  data.member_data.md_weight,
  data.belt_grades_data.bgd_name,
  data.belt_grades_data.bgd_klevel_id,
  contest.entry.en_orgid,".DBData::$mainUserBDate,
	DBData::$entryContestID."=".$_POST["contestID"]."
	Group By
  contest.entry.en_muid, data.main_user.mu_name, data.member_data.md_weight,data.belt_grades_data.bgd_klevel_id,
  data.belt_grades_data.bgd_name, contest.entry.en_orgid, contest.entry.en_ctime,".DBData::$mainUserBDate."
  Order By
  contest.entry.en_ctime",
	"Inner Join
  data.main_user
    On contest.entry.en_muid = data.main_user.mu_id Inner Join
  org.club_mship_history
    On org.club_mship_history.ch_member_id = data.main_user.mu_id
    Inner Join
  data.member_data
    On data.member_data.md_muid = data.main_user.mu_id
    Inner Join
  data.belt_grades_data
    On data.member_data.md_beltgradesid = data.belt_grades_data.bgd_id");

$resultOrg =$DBTasks->selectGetResult(DBData::getEntryTable(),
	DBData::getMainUserTable().".".DBData::$mainUserID.",".
	DBData::getMainUserTable().".".DBData::$mainUserName,DBData::$entryContestID."=".$_POST["contestID"]."
	GROUP BY ".DBData::getMainUserTable().".".DBData::$mainUserID.",".
	DBData::getMainUserTable().".".DBData::$mainUserName,
	"Join
  data.main_user
    On contest.entry.en_orgid = data.main_user.mu_id");
$MemberArray = array();
$OrgArray = array();
if(pg_num_rows($result)>0){
	while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
		//echo $row[DBData::$mainUserName]."<br>";
		array_push($MemberArray,$row);
	}
	while($row = pg_fetch_row($resultOrg, NULL, PGSQL_ASSOC)){
		//echo $row[DBData::$mainUserName]."<br>";
		array_push($OrgArray,$row);
	}
}


echo "<div class='modal fade ' id='checkEntryModal'>
	<div class='modal-dialog modal-lg'>
	<div class='modal-content'>
		<div class='modal-header'>";
		echo "Nevezések";
echo "</div>";
echo "<div class='modal-body'>";
if(count($MemberArray)>0 && count($OrgArray)>0){
	foreach ($OrgArray as $orgItem) {
		echo "<div class='panel panel-default'>
					<div class='panel-heading'>".$orgItem[DBData::$mainUserName]."</div>
					<div class='panel-body'>";
		foreach ($MemberArray as $memberItem) {
			if($memberItem[DBData::$entryorgID] == $orgItem[DBData::$mainUserID]){
				$user = new SportUser(null,
										$memberItem[DBData::$mainUserName],
										null,null,null,null,$memberItem[DBData::$mainUserBDate],
						$memberItem[DBData::$mainUserBDate],
						$memberItem[DBData::$memberDataWeight],
						$memberItem[DBData::$beltGradesName],
						$memberItem[DBData::$beltGradesLevelId]);
				?>
					<div class="row">
						<div class='col-md-3'>Név: <?php echo $user->getName()?></div>
						<div class='col-md-3'>Súly: <?php echo $user->getWeight_toString()?></div>
						<div class='col-md-3'>Öv fokozat: <?php echo $user->getKnowLedgeId_toString()?></div>
						<div class='col-md-3'>Életkor: <?php echo $user->getAge()?></div>
					</div>
				<hr>
				<?php
			}
		}
		echo "
				</div>
			</div>";
	}
}
else {
	echo "Nem neveztek még a versenyre";
}


echo "</div><div class='modal-footer'>
<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>
</div>
</div>

</div>
</div>";
