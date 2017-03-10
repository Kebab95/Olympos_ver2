<?php
include "../../../includeClasses.php";
$DBTasks = new DBTasks();
DBLoad::init();
$DBTasks->Connect();
$result = $DBTasks->sql('Select
  *
From
  contest_data.admin_edit_cat
Where
  contest_data.admin_edit_cat.aec_adminid = '.$_POST["adminID"].' And
  contest_data.admin_edit_cat.aec_ccc_id = '.$_POST["cccID"]);
$DBTasks->ConnClose();
if(pg_num_rows($result)>0){
	$row = pg_fetch_row($result, NULL, PGSQL_ASSOC);
	if($row["aec_under_editing"]=="f"){
		$DBTasks->Connect();
		$DBTasks->sql('UPDATE contest_data.admin_edit_cat SET aec_under_editing=true, aec_ltime=NOW() WHERE
contest_data.admin_edit_cat.aec_adminid = '.$_POST["adminID"].' And
  contest_data.admin_edit_cat.aec_ccc_id = '.$_POST["cccID"]);
		$DBTasks->ConnClose();
	}
}else {
	$DBTasks->Connect();
	$DBTasks->sql('INSERT INTO contest_data.admin_edit_cat (aec_adminid,aec_ccc_id,aec_under_editing) VALUES (
				'.$_POST["adminID"].',
				'.$_POST["cccID"].',
				true
)');
	$DBTasks->ConnClose();
}

$DBTasks->Connect();
$userResult =$DBTasks->sql('Select
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
$DBTasks->ConnClose();

$userSeq = array();
$userArray = array();
while($row =pg_fetch_row($userResult, NULL, PGSQL_ASSOC)){
	array_push($userArray,SportUser::createWithDB($row));
	array_push($userSeq,$row["a_seq"]);
}

$allRes = $DBTasks->sqlWithConn('SELECT * FROM contest.contest_comp WHERE ccc_id='.$_POST["cccID"]);


$all =pg_fetch_row($allRes, NULL, PGSQL_ASSOC);
$tempCat = DBLoad::loadCategory($all["ccc_cat_id"]);
$DBTasks->Connect();
$compTypeResult =$DBTasks->sql('Select
  contest.comp_types.comp_types_fighting_event AS fight,
  contest.comp_types.comp_types_technical_event AS technical,
  contest.comp_types.comp_types_group_event AS groupeven
From
  contest.contest_comp Inner Join
  contest.competetions
    On contest.contest_comp.ccc_comp_id = contest.competetions.comp_id
  Inner Join
  contest.comp_types
    On contest.competetions.type_id = contest.comp_types.comp_types_id
Where
  contest.contest_comp.ccc_cat_id = '.$tempCat->getId().'
  LIMIT 1');
$DBTasks->ConnClose();
$compType = pg_fetch_row($compTypeResult,NULL, PGSQL_ASSOC);

$DBTasks->Connect();
$strugleResult = $DBTasks->sql('Select
  *
From
  contest_data.strugle_data Inner Join
  contest.contest_comp
    On contest_data.strugle_data.s_ccc_id = contest.contest_comp.ccc_id
    Where
  contest.contest_comp.ccc_id = '.$_POST["cccID"].'
  Order By
  contest_data.strugle_data.s_ctime');
$DBTasks->ConnClose();

$strugleArray = array();
if(pg_num_rows($strugleResult)>0){
	while($row =pg_fetch_row($strugleResult, NULL, PGSQL_ASSOC)){
		array_push($strugleArray,$row);
	}
}



?>
<div class="panel panel-primary">
	<div class="panel-heading">
		<?php echo $tempCat?>, Divizió: <?php echo $allRes["ccc_division"]?>
	</div>
	<div class="panel-body" id="strugleData">
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<?php
				//Mehet tovább a verseny
				$switch = false;
				if($compType["fight"]=="t"){
					switch(count($userArray)){
						case 2:
							if(count($strugleArray)==1){
								$switch=true;
							}
							break;
						case 3:
							if(count($strugleArray)==3){
								$switch=true;
							}
							break;
						default:
							if((count($strugleArray))-1==count($userArray)){
								$switch=true;
							}
					}
					if($switch){
						echo "Nincs több a küzdelemn";
					}
					else {
						?>
						<button class="btn btn-success btn-block" id="strugleStart" onclick="strugleStart()">Következő Küzdelem indítása</button>
						<?php
					}
				}
				?>

			</div>
			<div class="col-md-4 text-center">
				<?php
				if($compType["fight"]=="t"){
					?>
					<p>Verseny típus: <?php echo ((count($userArray)==2)?"1v1":((count($userArray)==3)?"Körbe ütés":((count($userArray)>3)?"Egyenes kiütéses küzdelem":"Hiba (Csak egy versenyző van ebben a kategóriában)")))?></p>
					<?php
				}
				?>

			</div>
		</div>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12 text-center">Lefutott küzdelmek</div>
		</div>
	</div>
	<div class="table-responsive">
	<table class="table">
		<thead>
		<tr>
			<td width='10px'>Sorrend</td>
			<td>Első versenyző</td>
			<td>Első Pontjai</td>

			<td>Második versenyző</td>
			<td>Második Pontjai</td>
			<td>Győztes versenyző</td>
			<td>Forduló</td>
		</tr>
		</thead>
		<tbody id="strugleTable">
		<?php
			if(count($strugleArray)>0){
				foreach ( $strugleArray as $key =>$racer) {
					$race1Name = DBLoad::loadUserWithoutActive($racer["s_racer_1"]);
					$race2Name = DBLoad::loadUserWithoutActive($racer["s_racer_2"]);
					echo "<tr>";
					echo "<td width='10px'>".($key+1)."</td>";
					echo "<td class='alert-danger' style='color: white;'>".$race1Name->getName()."</td>";
					echo "<td>".$racer["s_racer_1_point"]."</td>";
					echo "<td style=\"background-color: #002a80;color: white;\">".$race2Name->getName()."</td>";
					echo "<td>".$racer["s_racer_2_point"]."</td>";
					echo "<td ".($racer["s_winner_id"]==$race1Name->getId()?"class='alert-danger' style='color: white;'":"style=\"background-color: #002a80;color: white;\"").">".($racer["s_winner_id"]==$race1Name->getId()?$race1Name->getName():$race2Name->getName())."</td>";
					echo "<td>".$racer["s_circle"].". Forduló</td>";
					echo "</tr>";
				}
			}
		else {
			echo "<tr><td colspan='7' class='text-center'>Még nincsen eredmény</td></tr>";
		}
		?>
		</tbody>
	</table>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-12 text-center">Kategória résztvevői</div>
		</div>
	</div>
	<table class="table">
		<thead>
			<tr>
				<td>Név</td>
				<td>Életkor</td>
				<?php
				if($compType["fight"]=="t"){
					echo "<td>Súly</td>";
				}
				else if($compType["technical"] =="t"){
					echo "<td>Tudás szint</td>";
				}
				else {
					echo "<td>Csoport (Fejlesztés alatt)</td>";
				}
				?>
				<td>Sorrend</td>
			</tr>
		</thead>
		<tbody>
			<?php
			/** @var SportUser $user */
			foreach ($userArray as $key => $user) {
				echo "<tr>";
				echo "<td>".$user->getName()."</td>";
				echo "<td>".$user->getAge()."</td>";
				if($compType["fight"]=="t"){
					echo "<td>".$user->getWeight()."</td>";
				}
				else if($compType["technical"] =="t"){
					echo "<td>".$user->getBeltGrades().", ".$user->getKnowLedgeId_toString()."</td>";
				}
				else {
					echo "<td>Csoport (Fejlesztés alatt)</td>";
				}
				echo "<td>".$userSeq[$key]."</td>";
				echo "</tr>";
			}
			?>
		</tbody>
	</table>

	<div class="panel-footer">
		<div class="row">
			<div class="col-md-6">
				<button class="btn btn-danger btn-block" id="Close">Bezárás</button>
			</div>
			<div class="col-md-6">
				<button class="btn btn-success btn-block">Véglegesítés</button>
			</div>
		</div>
	</div>
</div>
<script>
	function strugleStart(){
		$.ajax({
			url:'Model/contestView/adminLog/model_ajax_newStartStrugle.php',
			type: 'POST',
			data: {
				cccID: <?php echo $all["ccc_id"]?>,
				compType: <?php echo "'".($compType["fight"]=="t"?"fight":($compType["technical"]=="t"?"technical":"error"))."'"?>,
				adminID: <?php echo  $_POST["adminID"]?>
			},
			dataType: 'html'
		}).done(function(data){
			console.log(data);
			$('#strugleData').fadeOut(500, function() {
				//this is a callback once the element has finished hiding

				//populate the div with whatever was returned from the ajax call
				$(this).html(data);
				//fade in with new content
				$(this).fadeIn(500);
			});

		}).fail(function(){
			alert("Hiba!");
		});
	}
	$("#strugleStart").click(function (e){

	});
	$("#Close").click(function(e){
		$.ajax({
			url:'Model/contestView/adminLog/model_ajax_adminCloseCat.php',
			type: 'POST',
			data: {
				cccID: <?php echo $all["ccc_id"]?>,
				adminID: <?php echo  $_POST["adminID"]?>
			},
			dataType: 'html'
		}).done(function(data){
			console.log(data);
			$('#adminBody').fadeOut(500, function() {
				//this is a callback once the element has finished hiding

				//populate the div with whatever was returned from the ajax call
				$(this).html(data);
				//fade in with new content
				$(this).fadeIn(500);
			});

		}).fail(function(){
			alert("Hiba!");
		});
	});
</script>