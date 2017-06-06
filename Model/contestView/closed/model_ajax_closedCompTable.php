<?php
include "../../../includeClasses.php";
$DBTasks = new DBTasks();
DBLoad::init();
$justClosed = $_POST["justClosed"]=="true";

$comp = DBLoad::loadCompetetion($_POST["compID"]);
if($comp->getType()->getEvents(DBData::getCompTypesFlag(0))){
	$eventType = DBData::getCompTypesFlag(0);
}
else {
	$eventType = DBData::getCompTypesFlag(1);
}
$sql = 'Select
  Count(contest.assignment.a_muid) As user_count,
  contest.contest_comp.ccc_cat_id,
  contest.contest_comp.ccc_comp_id,
  contest.contest_comp.ccc_division,
  contest.contest_comp.ccc_id
From
  contest.assignment Inner Join
  contest.contest_comp
    On contest.assignment.a_ccc_id = contest.contest_comp.ccc_id Inner Join
  contest.competetions
    On contest.contest_comp.ccc_comp_id = contest.competetions.comp_id
  Inner Join
  contest.comp_types
    On contest.competetions.type_id = contest.comp_types.comp_types_id
Where
  contest.contest_comp.ccc_contest_id = '.$_POST["contestID"].' And
  contest.comp_types.'.$eventType.' = True
Group By
  contest.contest_comp.ccc_cat_id, contest.competetions.type_id,
  contest.comp_types.'.$eventType.', contest.contest_comp.ccc_comp_id,
  contest.contest_comp.ccc_id';
//echo $sql;

$userArrayRes = $DBTasks->sqlWithConn($sql);

$userArray = array();
$strugleArray = array();
while($row =pg_fetch_row($userArrayRes, NULL, PGSQL_ASSOC)){
	if(isset($userArray[$row[DBData::$connCCC_Id]])){
		array_push($userArray[$row[DBData::$connCCC_Id]],$row["user_count"]);
	}
	else {
		$userArray[$row[DBData::$connCCC_Id]]["count"] = $row["user_count"];
		$userArray[$row[DBData::$connCCC_Id]]["catID"] = $row["ccc_cat_id"];
		$userArray[$row[DBData::$connCCC_Id]]["division"] = $row["ccc_division"];

		if($comp->getType()->getEvents(DBData::getCompTypesFlag(0))){
			$strugleResult = $DBTasks->sqlWithConn('Select
			  *
			From
			  contest_data.strugle_data Inner Join
			  contest.contest_comp
			    On contest_data.strugle_data.s_ccc_id = contest.contest_comp.ccc_id
			    Where
			  contest.contest_comp.ccc_id = '.$row[DBData::$connCCC_Id].'
			  Order By
			  contest_data.strugle_data.s_ctime');
		}
		else if($comp->getType()->getEvents(DBData::getCompTypesFlag(1))){
			$strugleResult = $DBTasks->sqlWithConn('Select
			  *
			From
			  contest_data.technical_strugle_data Inner Join
			  contest.contest_comp
			    On contest_data.technical_strugle_data.ts_ccc_id = contest.contest_comp.ccc_id
			    Where
			  contest.contest_comp.ccc_id = '.$row[DBData::$connCCC_Id].' AND
  contest_data.technical_strugle_data.ts_use = True
			  Order By
			  contest_data.technical_strugle_data.ts_ctime');
		}
		$tempstrugleArray = array();
		if(pg_num_rows($strugleResult)>0){
			while($asd =pg_fetch_row($strugleResult, NULL, PGSQL_ASSOC)){
				array_push($tempstrugleArray,$asd);
			}
		}
		$strugleArray[$row[DBData::$connCCC_Id]]["count"] = count($tempstrugleArray);
		$strugleArray[$row[DBData::$connCCC_Id]]["ccc_ID"] = $row[DBData::$connCCC_Id];
	}
}


?><div class="row"> <?php
	$db = 0;
	$closed = 0;
foreach ($userArray as $key => $item) {
	foreach ($strugleArray as $index => $value) {

		if($key==$index){
			$db++;
			$switch = false;
			if($comp->getType()->getEvents(DBData::getCompTypesFlag(0))){
				switch($item["count"]){
					case 2:
						if($value["count"]==1){
							$switch=true;
						}
						break;
					case 3:
						if($value["count"]==3){
							$switch=true;
						}
						break;
					case 4:
						if($value["count"]==3){
							$switch=true;
						}
						break;
					case 8:
						if($value["count"]==7){
							$switch = true;
						}
						break;
				}
				if($switch || !$justClosed){
					if($switch){
						$closed++;
					}

					$tempCat = DBLoad::loadCategory($item["catID"]);
					?>
						<div class="col-md-6 col-xs-12 form-group">
							<div class="row">
								<div class="col-md-1 col-xs-1">

								</div>
								<div class="col-md-10 col-xs-10" style="background-color: <?php echo $switch?"#2b669a":"#ac2925"?>;padding: 10px;">
									<div class="row">
										<div class="col-xs-6">
											<?php
											echo $tempCat.", Divizió: ".UserTasks::getDivision_toString($item["division"]);
											?>
										</div>
										<div class="col-xs-6 text-center">
											<?php
											if($switch){
												?>
												<button class="btn btn-success btn-block" onclick="showCatLeaderboard(<?php echo $value["ccc_ID"]?>)">Tovább</button>
												<?php
											}
											else {
												echo "<label>Nincs lezárva</label>";
											}
											?>

										</div>
									</div>
								</div>
								<div class="col-md-1 col-xs-1">
									&nbsp;
								</div>
							</div>
						</div>

					<?php
				}
			}
			else if($comp->getType()->getEvents(DBData::getCompTypesFlag(1))){
				if($value["count"]==$item["count"]|| !$justClosed){
					if($value["count"]==$item["count"]){
						$closed++;
					}

					$tempCat = DBLoad::loadCategory($item["catID"]);
					?>
					<div class="col-md-6 col-xs-12 form-group">
						<div class="row">
							<div class="col-md-1 col-xs-1">
								&nbsp;
							</div>
							<div class="col-md-10 col-xs-10" style="background-color: <?php echo $value["count"]==$item["count"]?"#2b669a":"#ac2925"?>;padding: 10px;">
								<div class="row">
									<div class="col-xs-6">
										<?php
										echo $tempCat.", Divizió: ".UserTasks::getDivision_toString($item["division"]);
										?>
									</div>
									<div class="col-xs-6 text-center">
										<?php
										if($value["count"]==$item["count"]){
											?>
											<button class="btn btn-success btn-block" onclick="showCatLeaderboard(<?php echo $value["ccc_ID"]?>)">Tovább</button>
											<?php
										}
										else {
											echo "<label>Nincs lezárva</label>";
										}
										?>

									</div>
								</div>
							</div>
							<div class="col-md-1 col-xs-1">
								&nbsp;
							</div>
						</div>
					</div>

					<?php
				}
			}
		}
	}
}
?></div>
<div id="leaderboardModalhire"></div>
<script>
	$(document).ready(function(){
		$("#counter").html('<div class="row">' +
				'<div class="col-xs-6 text-right"><?php echo $db?></div>' +
				'<div class="col-xs-6"><?php echo $closed?></div>' +
				'</div>' +
				'<div class="row">' +
				'<div class="col-xs-6 text-right">' +
				'Összesen' +
				'</div>' +
				'<div class="col-xs-6">' +
				'Lezárt' +
				'</div>' +
				'</div>');
	});
	function showCatLeaderboard(cccID){
		$.ajax({
			url: 'Model/contestView/closed/model_ajax_leaderboardModal.php',
			type: 'POST',
			data: {cccID: cccID,type:'<?php echo ($comp->getType()->getEvents(DBData::getCompTypesFlag(0))?DBData::getCompTypesFlag(0):DBData::getCompTypesFlag(1)) ?>'},
			dataType: 'html'
		}).done(function(data){
			console.log(data);
			$("#leaderboardModalhire").html(data);
			$("#leaderBoardModal").modal("show").on('hidden.bs.modal', function () {
				setTimeout(function(){
					$("#leaderboardModalhire").html("");
				},500);
			});
			$("#leaderboardModalClose").on("click",function(){
				$("#leaderBoardModal").modal("toggle");

				setTimeout(function(){
					$("#leaderboardModalhire").html("");
				},500);

			});

		}).fail(function(){
			alert('Ajax Submit Failed ...');
		});
	}
</script>
<?php