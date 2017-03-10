<?php
if(isset($_POST["cccID"]) && isset($_POST["adminID"]) && (isset($_POST["compType"]) && $_POST["compType"]!="error")){
	include "../../../includeClasses.php";
	$DBTasks = new DBTasks();
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
	$userArray = array();
	while($row =pg_fetch_row($userResult, NULL, PGSQL_ASSOC)){
		array_push($userArray,SportUser::createWithDB($row));
	}
	$outComeType = $DBTasks->sqlWithConn('Select
  *
From
  contest_data.outcome_type');
	$outComeTypeArray = array();
	while($row =pg_fetch_row($outComeType, NULL, PGSQL_ASSOC)){
		array_push($outComeTypeArray,$row);
	}
	$userCount = count($userArray);
	$DBTasks = new DBTasks();
	if($_POST["compType"]=="fight"){
		if($userCount==2 || $userCount==3){
			/** @var SportUser $racer1 */
			/** @var SportUser $racer2 */

			if($userCount==2){
				$racer1 = $userArray[0];
				$racer2 = $userArray[1];
			}
			else {
				$strugle =$DBTasks->sqlWithConn('Select
			  count(*) as ossz
			From
			  contest_data.strugle_data
			Where
			  contest_data.strugle_data.s_ccc_id = '.$_POST["cccID"]);

				$countStrugle =pg_fetch_row($strugle, NULL, PGSQL_ASSOC);
				switch($countStrugle["ossz"]){
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
			}
			?>
			<form method="post" action="" id="raceForm">
				<div class="row">
					<div class="col-md-4">
						<div class="row">
							<div class="col-md-12 alert-danger" style=" color: white;height: 40px;">
								<?php echo $racer1->getName();?>
								<input type="hidden" name="racer1ID" value="<?php echo $racer1->getId()?>">
							</div>
						</div>
						<div class="row">
							<div class="col-md-12" style="background-color: #002a80; color: white; height: 40px;">
								<?php echo $racer2->getName();?>
								<input type="hidden" name="racer2ID" value="<?php echo $racer2->getId()?>">
							</div>
						</div>
					</div>
					<div class="col-md-8">
						<div class="row form-group">
							<div class="col-md-3 text-center">Piros verseyző Elért pontja</div>
							<div class="col-md-3"><input type="number" required class="form-control" name="race1Point"></div>
							<div class="col-md-3 text-center">Kék verseyző Elért pontja</div>
							<div class="col-md-3"><input type="number" required class="form-control" name="race2Point"></div>


						</div>
						<div class="row form-group">
							<div class="col-md-3 text-center">Végső győztes</div>
							<div class="col-md-3"><select class="form-control" name="winnerID">
									<?php
									echo "<option value='".$racer1->getId()."'>".$racer1->getName()."</option>";
									echo "<option value='".$racer2->getId()."'>".$racer2->getName()."</option>";
									?>
								</select></div>
							<div class="col-md-3 text-center">A vesztes miért esett ki?</div>
							<div class="col-md-3"><select class="form-control" name="loseCome" >
									<?php foreach ($outComeTypeArray as $item) {
										echo "<option value=".$item["ut_id"].">".$item["ut_name"]."</option>";
									} ?>
								</select></div>

						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-2">
						Jegyzet (Nem kötelező)
					</div>
					<div class="col-md-10">
						<input class="form-control" type="text" name="log">
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<button type="submit" class="btn btn-success btn-block">Lezárás</button>
						<input type="hidden" name="cccID" value="<?php echo $_POST["cccID"]?>">
						<input type="hidden" name="adminID" value="<?php echo $_POST["adminID"]?>">
					</div>
				</div>
			</form>
			<script>
				$("#raceForm").submit(function(e){
					e.preventDefault();
					var datas = $(this).serializeArray();
					if (parseInt(datas[2].value) >0 && parseInt(datas[3].value)>0){
						$.ajax({
							url:'Model/contestView/adminLog/model_ajax_submitStrugle.php',
							type: 'POST',
							data: $(this).serialize(),
							dataType: 'JSON'
						}).done(function(data){
							console.log(data);
							$("#strugleData").html(data[0]);
							$("#strugleTable").html(data[1]);
						}).fail(function(){
							alert("Hiba!");
						});
					}
					else {
						alert("Adjon meg 0-nál nagyobb számot!");
					}

				});
			</script>

			<?php

		}
		else if($userCount>3){
			include "model_ajax_startStugle2.php";
		}
		else {

		}



	}
	else if($_POST["compType"]=="technical"){

	}






}
function asd(){
	$string = '<div class="row"><div class="col-md-4"></div><div class="col-md-4"><button class="btn btn-success btn-block" id="strugleStart">Következő Küzdelem indítása</button>
			</div>
			<div class="col-md-4 text-center">
				<?php
				if($compType["fight"]=="t"){

					<p>Verseny típus: <?php echo ((count($userArray)==2)?"1v1":((count($userArray)==3)?"Körbe ütés":((count($userArray)>3)?"Egyenes kiütéses küzdelem":"Hiba (Csak egy versenyző van ebben a kategóriában)")))?></p>
					<?php
				}
				?>

			</div>
		</div>';
	return $string;
}

