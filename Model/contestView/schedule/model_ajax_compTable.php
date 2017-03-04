<?php
include "../../../includeClasses.php";
$DBTasks = new DBTasks();
DBLoad::init();
$DBTasks->Connect();
$result = $DBTasks->sql('Select
  *
From
  contest.assignment Inner Join
  contest.contest_comp
    On contest.assignment.a_ccc_id = contest.contest_comp.ccc_id Inner Join
  data.main_user
    On contest.assignment.a_muid = data.main_user.mu_id Left Join
  data.email_data
    On data.main_user.mu_email_id = data.email_data.ed_id Left Join
  data.telefon_data
    On data.main_user.mu_telefon_id = data.telefon_data.td_id Inner Join
  data.member_data
    On data.member_data.md_muid = data.main_user.mu_id Inner Join
  data.belt_grades_data
    On data.member_data.md_beltgradesid = data.belt_grades_data.bgd_id
Where
  contest.contest_comp.ccc_comp_id = '.$_POST["compID"]);
$DBTasks->ConnClose();
if(pg_num_rows($result)>0){
	$tempArray = array();
	while($row =pg_fetch_row($result, NULL, PGSQL_ASSOC)){
		array_push($tempArray,$row);
	}
	$tempCatArray = array();
	$DBTasks->Connect();
	$resultCat = $DBTasks->sql('Select
  		contest.contest_comp.ccc_cat_id
		From
		  contest.assignment Inner Join
		  contest.contest_comp
		    On contest.assignment.a_ccc_id = contest.contest_comp.ccc_id
		Where
		  contest.contest_comp.ccc_comp_id = '.$_POST["compID"].'
		Group By
		  contest.contest_comp.ccc_comp_id, contest.contest_comp.ccc_cat_id');
	$DBTasks->ConnClose();
	while($row =pg_fetch_row($resultCat, NULL, PGSQL_ASSOC)){
		$tempCatArray[$row[DBData::$connCCC_CatID]] = DBLoad::loadCategory($row[DBData::$connCCC_CatID]);
	}
	/** @var CompCategory $category */
	?>
		<hr>
		<div class="row">
			<div class="col-xs-1">#</div>
			<div class="col-xs-2">Név</div>
			<div class="col-xs-2">Életkora</div>
			<div class="col-xs-2">Súlya</div>
			<div class="col-xs-3">Egyesülete</div>
			<div class="col-xs-2">Egyesülete</div>
		</div>
	<?php
	foreach ($tempCatArray as $key => $category) {
		?>
			<div class="panel panel-default">
				<div class="panel-heading">
					Nem: <?php echo $category->getActualSex()?>,&nbsp;
					Kor: <?php echo $category->getAgeMin()." - ".$category->getAgeMax()?>,&nbsp;
					Csoport: <?php echo ($category->getPersonalGrpTitle())?>
				</div>
				<div class="table-responsive">
					<table class="table table-hover table-bordered table-stripped">
						<?php
						$db = 1;
						foreach ($tempArray as $item) {
							if($item[DBData::$connCCC_CatID] == $key){
								$tempUser = SportUser::createWithDB($item);
								$tempOrg = DBLoad::loadOrg($item["a_orgid"]);
								echo "<tr>";
								echo "<td width='5%'>".$db."</td>";
								echo "<td width='20%'>".$tempUser->getName()."</td>";
								echo "<td width='20%'>".$tempUser->getAge()."</td>";
								echo "<td width='20%'>".$tempUser->getWeight()." kg</td>";
								echo "<td width='20%'>".$tempOrg->getName()."</td>";
								echo "<td width='5%'><span class='glyphicon glyphicon-arrow-up'></span></td>";
								echo "<td width='5%'><span class='glyphicon glyphicon-arrow-down'></span></td>";
								echo "<td width='15%'><button class='btn btn-block btn-default'>Nevezései</button> </td>";
								echo "</tr>";
								$db++;
							}
						}
						?>
					</table>
				</div>
			</div>
		<?php
	}
}
else {
	?>
		<div class="panel">
			<div class="panel-body">
				Nincsenek még versenyzők
			</div>
		</div>
	<?php
}