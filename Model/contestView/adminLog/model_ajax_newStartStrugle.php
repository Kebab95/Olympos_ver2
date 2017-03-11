<?php
if(isset($_POST["cccID"]) && isset($_POST["adminID"]) && (isset($_POST["compType"]) && $_POST["compType"]!="error")){
	include "../../../includeClasses.php";
	$DBTasks = new DBTasks();
	$strugleCircleRes = $DBTasks->sqlWithConn('SELECT s_circle FROM  contest_data.strugle_data
					Where
					  contest_data.strugle_data.s_ccc_id = '.$_POST["cccID"].'
					  ORDER BY s_circle DESC LIMIT 1');
	if(pg_num_rows($strugleCircleRes)!=1){
		$strugleCircle = 1;
	}
	else {
		$strugleCircle =pg_fetch_row($strugleCircleRes, NULL, PGSQL_ASSOC)["s_circle"];
	}

	$strugle =$DBTasks->sqlWithConn('Select
			  count(*) as ossz
			From
			  contest_data.strugle_data
			Where
			  contest_data.strugle_data.s_ccc_id = '.$_POST["cccID"].' AND
			  contest_data.strugle_data.s_circle = '.$strugleCircle);

	$countStrugle =pg_fetch_row($strugle, NULL, PGSQL_ASSOC)["ossz"];


	if($strugleCircle==1){
		$userResult =$DBTasks->sqlWithConn('Select
			  *
			From
			  contest.assignment Inner Join
			  contest.contest_comp
			    On contest.assignment.a_ccc_id = contest.contest_comp.ccc_id Inner Join
			  contest_data.admin_edit_cat
			    On contest_data.admin_edit_cat.aec_ccc_id = contest.contest_comp.ccc_id
			  Inner Join
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
			    WHERE contest_data.admin_edit_cat.aec_adminid = '.$_POST["adminID"].' And
			  contest_data.admin_edit_cat.aec_ccc_id = '.$_POST["cccID"].'
			  ORDER BY a_seq');
	}
	else {
		$userResult = $DBTasks->sqlWithConn('Select
				  data.main_user.*,
				  data.member_data.*,
				  data.belt_grades_data.*,
				  data.knowledge_level.*,
				  data.telefon_data.*,
				  data.email_data.*
				From
				  contest_data.strugle_data Inner Join
				  data.main_user
				    On data.main_user.mu_id = contest_data.strugle_data.s_winner_id Inner Join
				  data.email_data
				    On data.main_user.mu_email_id = data.email_data.ed_id Inner Join
				  data.telefon_data
				    On data.main_user.mu_telefon_id = data.telefon_data.td_id Inner Join
				  data.member_data
				    On data.member_data.md_muid = data.main_user.mu_id Inner Join
				  data.belt_grades_data
				    On data.member_data.md_beltgradesid = data.belt_grades_data.bgd_id
				  Inner Join
				  data.knowledge_level
				    On data.belt_grades_data.bgd_klevel_id = data.knowledge_level.klevel_id
				Where
				 contest_data.strugle_data.s_ccc_id = '.$_POST["cccID"].' AND
				  contest_data.strugle_data.s_circle = '.($strugleCircle-1).'
			    order by s_lctime');
	}

	$userArray = array();
	while($row =pg_fetch_row($userResult, NULL, PGSQL_ASSOC)){
		array_push($userArray,SportUser::createWithDB($row));
	}
	$userCount = count($userArray);

	if($countStrugle==($userCount/2)){
		$strugleCircle++;
		$userResult = $DBTasks->sqlWithConn('Select
				  data.main_user.*,
				  data.member_data.*,
				  data.belt_grades_data.*,
				  data.knowledge_level.*,
				  data.telefon_data.*,
				  data.email_data.*
				From
				  contest_data.strugle_data Inner Join
					  data.main_user
					    On data.main_user.mu_id = contest_data.strugle_data.s_winner_id Left Join
					  data.email_data
					    On data.main_user.mu_email_id = data.email_data.ed_id Left Join
					  data.telefon_data
					    On data.main_user.mu_telefon_id = data.telefon_data.td_id Left Join
					  data.member_data
					    On data.member_data.md_muid = data.main_user.mu_id Left Join
					  data.belt_grades_data
					    On data.member_data.md_beltgradesid = data.belt_grades_data.bgd_id
					  Left Join
					  data.knowledge_level
					    On data.belt_grades_data.bgd_klevel_id = data.knowledge_level.klevel_id
				Where
				 contest_data.strugle_data.s_ccc_id = '.$_POST["cccID"].' AND
				  contest_data.strugle_data.s_circle = '.($strugleCircle-1).'
			    order by s_lctime');
		$userArray = array();
		while($row =pg_fetch_row($userResult, NULL, PGSQL_ASSOC)){
			array_push($userArray,SportUser::createWithDB($row));
		}
		$userCount = count($userArray);
	}


	$outComeType = $DBTasks->sqlWithConn('Select
											  *
											From
											  contest_data.outcome_type');
	$outComeTypeArray = array();

	while($row =pg_fetch_row($outComeType, NULL, PGSQL_ASSOC)){
		array_push($outComeTypeArray,$row);
	}



	$racer1 = null;
	$racer2 = null;
	if($_POST["compType"] =="fight"){

		switch($userCount){
			case 1: break;
			case 2:
				$racer1 = $userArray[0];
				$racer2 = $userArray[1];
				break;
			case 3:

				switch($countStrugle){
					case 0:
						$racer1 = $userArray[0];
						$racer2 = $userArray[1];
						break;
					case 1:
						$racer1 = $userArray[1];
						$racer2 = $userArray[2];
						break;
					case 2:
						$racer1 = $userArray[2];
						$racer2 = $userArray[0];
						break;
					default:
						break;

				}
				break;
			default:
				switch($countStrugle){
					case 0:
						$racer1 = $userArray[0];
						$racer2 = $userArray[1];
						break;
					case 1:
						$racer1 = $userArray[2];
						$racer2 = $userArray[3];
						break;
					case 2:
						$racer1 = $userArray[4];
						$racer2 = $userArray[5];
						break;
					case 3:
						$racer1 = $userArray[6];
						$racer2 = $userArray[7];
						break;
				}

				break;

		}
		if($racer1!=null && $racer2!=null){
			/** @var SportUser $racer1 */
			/** @var SportUser $racer2 */
			?>
			<form method="post" action="" id="raceForm">
				<div class="row">
					<div class="col-md-4" ></div>
					<div class="col-md-4 text-center">
						<?php echo $strugleCircle?>. Forduló
						<input type="hidden" value="<?php echo $strugleCircle?>" name="circle">
					</div>
					<div class="col-md-4"></div>
				</div>
				<div class="row">
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12" style="background-color: red">&nbsp;</div>
						</div>
						<div class="row">
							<div class="col-md-4"></div>
							<div class="col-md-4 text-center" style="padding: 10px">
								<?php echo $racer1->getName()?>
								<input type="hidden" name="racer1ID" value="<?php echo $racer1->getId()?>">
							</div>
							<div class="col-md-4"></div>
						</div>
						<div class="row form-group">
							<div class="col-md-6">Elért pontjai</div>
							<div class="col-md-6"><input type="number" required class="form-control" name="race1Point"></div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row">
							<div class="col-md-12" style="background-color: blue">&nbsp;</div>
						</div>
						<div class="row">
							<div class="col-md-4"></div>
							<div class="col-md-4 text-center" style="padding: 10px">
								<?php echo $racer2->getName();?>
								<input type="hidden" name="racer2ID" value="<?php echo $racer2->getId()?>">
							</div>
							<div class="col-md-4"></div>
						</div>
						<div class="row form-group">
							<div class="col-md-6">Elért pontjai</div>
							<div class="col-md-6"><input type="number" required class="form-control" name="race2Point"></div>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-md-6">
						<div class="row form-group">
							<div class="col-md-6">Végső győztes</div>
							<div class="col-md-6">
								<select class="form-control" name="winnerID">
									<option value="<?php echo $racer1->getId()?>"><?php echo $racer1->getName()?></option>
									<option value="<?php echo $racer2->getId()?>"><?php echo $racer2->getName()?></option>
								</select>
							</div>
						</div>
					</div>
					<div class="col-md-6">
						<div class="row form-group">
							<div class="col-md-6">A veszes miért esett ki</div>
							<div class="col-md-6">
								<select class="form-control" name="loseCome">
									<?php
									foreach ($outComeTypeArray as $outcome) {
										echo "<option value='".$outcome["ut_id"]."'>".$outcome["ut_name"]."</option>";
									}
									?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-3">Jegyzet (Nem kötelező)</div>
					<div class="col-md-9"><input type="text" class="form-control" name="log"></div>
				</div>
				<div class="row">
					<div class="col-md-4"></div>
					<div class="col-md-4">
						<input type="submit" class="btn btn-success btn-block" value="Lezárás">
						<input type="hidden" name="cccID" value="<?php echo $_POST["cccID"]?>">
						<input type="hidden" name="adminID" value="<?php echo $_POST["adminID"]?>">
					</div>
					<div class="col-md-4"></div>
				</div>
			</form>
			<script>
				$("#raceForm").submit(function(e){
					e.preventDefault();
					var data = $(this).serializeArray();
					console.log(data);
					if(data[2].value>0 && data[4].value>0){
						$.ajax({
							url:'Model/contestView/adminLog/model_ajax_newSubmitStrugle.php',
							type: 'POST',
							data: $(this).serialize(),
							dataType: 'JSON'
						}).done(function(data){
							//console.log(data);
							$("#strugleData").html(data[0]);
							$("#strugleTable").html(data[1]);
						}).fail(function(){
							alert("Hiba!");
						});
					}
					else {
						alert("Adjon 0-nál nagyobb értéket!");
					}
				});
			</script>
			<?php
		}


	}
}