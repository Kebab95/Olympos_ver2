<?php
include "../../../includeClasses.php";
$DBTasks = new DBTasks();
DBLoad::init();
$compTypeRes = $DBTasks->sqlWithConn('
	SELECT
		comp_types_fighting_event as fight,
		 comp_types_technical_event as technical
	 FROM contest.competetions
	INNER JOIN contest.comp_types ON
	contest.competetions.type_id = contest.comp_types.comp_types_id
	WHERE contest.competetions.comp_id = '.$_POST["compID"]);
$compType =pg_fetch_row($compTypeRes, NULL, PGSQL_ASSOC);
$result = $DBTasks->sqlWithConn('Select
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
  contest.contest_comp.ccc_comp_id = '.$_POST["compID"].'
  Order By
  contest.assignment.a_seq');
if(pg_num_rows($result)>0){
	$tempArray = array();
	while($row =pg_fetch_row($result, NULL, PGSQL_ASSOC)){
		array_push($tempArray,$row);
	}
	$tempCatArray = array();
	$division = array();
	$cccID = array();
	$DBTasks->Connect();
	$resultCat = $DBTasks->sql('Select
  		contest.contest_comp.ccc_id,
  		contest.contest_comp.ccc_cat_id,
  		contest.contest_comp.ccc_division
		From
		  contest.assignment Inner Join
		  contest.contest_comp
		    On contest.assignment.a_ccc_id = contest.contest_comp.ccc_id
		Where
		  contest.contest_comp.ccc_comp_id = '.$_POST["compID"].'
		Group By
		  contest.contest_comp.ccc_comp_id, contest.contest_comp.ccc_id,
		  contest.contest_comp.ccc_cat_id,
  		contest.contest_comp.ccc_division
  		ORder by contest.contest_comp.ccc_cat_id');
	$DBTasks->ConnClose();
	$index = 0;
	while($row =pg_fetch_row($resultCat, NULL, PGSQL_ASSOC)){
		$tempCatArray[$row[DBData::$connCCC_Id]] = DBLoad::loadCategory($row[DBData::$connCCC_CatID]);
		$cccID[$row[DBData::$connCCC_Id]] = $row[DBData::$connCCC_Id];
		$division[$row[DBData::$connCCC_Id]] = $row[DBData::$connCCC_Division];
		$index++;
	}
	/** @var CompCategory $category */
	?>

		<hr>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<?php
			$index2 = 0;
			$takePlace = $tempArray[$index2][DBData::$connCCC_TakePlace]=="f";

			if($takePlace){
				?><button class="btn btn-success btn-block" data-toggle='modal' data-target='#takePlaceModal'>Verseny szám lezárása</button><?php
			}
			?>

		</div>
		<div class="col-md-4"><button class="btn btn-info2 btn-block">Nyomtatás</button>

		</div>
	</div>
	<div class="modal fade" id="takePlaceModal" role="dialog">
		<div class="modal-dialog modal-sm">
			<div class="modal-content">
				<div class="modal-header">
					Lezárás
				</div>
				<div class="modal-body text-center">
					Biztos lezárja ezt a versenyszámot? Lezárás után látható lesz a jegyzőknek az adatok. Ez után már nem lehet szerkeszteni az adatokat
				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-6"><button class="btn btn-success btn-block" id="takePlaceYes">Igen</button></div>
						<div class="col-md-6"><button data-dismiss="modal" class="btn btn-danger btn-block">Mégse</button></div>
					</div>
				</div>
			</div>
		</div>
	</div>
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
	foreach ($cccID as $key => $asd) {
		$count = 0;
		foreach ($tempArray as $item) {
			if($item[DBData::$connCCC_Id] == $asd){
				$count++;
			}
		}
		$category = $tempCatArray[$key];
		?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<div class="row">
						<div class="col-md-5"><?php echo $category?>,&nbsp;
							Divizió: <?php echo UserTasks::getDivision_toString($division[$key])?></div>
						<div class="col-md-3">
							<?php
							if($count==2 || $count==3 || $count==4 || $count==8){
								echo "<input type='hidden' name='ervenyes[]' value='1'>";
							}
							else {
								echo "Érvénytelen számú versenyző a kategóriában!";
								echo "<input type='hidden' name='ervenyes[]' value='0'>";
							}?>
						</div>
						<div class="col-md-2">
							<?php
							if($count>3){
							    echo '<button class="btn btn-default btn-block" onclick="splitt('.$asd.')">Szétválasztás</button>';
							}
							?>

						</div>
						<div class="col-md-2">
							<?php
							echo '<button class="btn btn-default btn-block" onclick="mass('.$asd.')">Összevonás</button>';
							?>
						</div>
					</div>

				</div>
				<div class="table-responsive">
					<table class="table table-hover table-bordered table-stripped" id='<?php echo $category->getId()?>'>
						<?php
						$db = 1;
						foreach ($tempArray as $item) {
							if($item[DBData::$connCCC_Id] == $asd ){
								$tempUser = SportUser::createWithDB($item);
								$tempOrg = DBLoad::loadOrg($item["a_orgid"]);
								echo "<tr>";
									echo "<td width='5%'>".$item["a_seq"]."</td>";
									echo "<td width='20%'><a onclick='showModalProfile(".$_POST["userID"].",".$tempUser->getId().")' '> ".$tempUser->getName()."</p></td>";
									echo "<td width='20%'>".$tempUser->getAge()."</td>";
									echo "<td width='20%'>".$tempUser->getWeight()." kg</td>";
									echo "<td width='20%'>".$tempOrg->getName()."</td>";
									if($item[DBData::$connCCC_TakePlace]=="f"){
										echo "<td width='5%'>".($db>1?"<span onclick='seqUp(".$item["a_id"].",\"#".$category->getId()."\")' class='glyphicon glyphicon-triangle-top'></span>":"")."</td>";
										echo "<td width='5%'>".($db<$count?"<span onclick='seqDown(".$item["a_id"].",\"#".$category->getId()."\")' class='glyphicon glyphicon-triangle-bottom'></span>":"")."</td>";
									}
								else {
									echo "<td width='10%'><label class='label label-danger'>Lezárt</label> </td>";
								}

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
	?>
		<div id="tempModal"></div>
		<script>
			function splitt(cccID){
				$.ajax({
					url:'View/contestView/schedule/view_splittModal.php',
					type: 'POST',
					data: {cccID: cccID},
					dataType: 'html'
				}).done(function(data){
					$("#tempModal").html(data);
					setTimeout(function(){
						$("#splitModal").modal('show');
					},500);

					//console.log(data);
					//location.reload();


				}).fail(function(){
					alert("Hiba!");
				});
			}
			function mass(cccID){
				$.ajax({
					url:'View/contestView/schedule/view_massModal.php',
					type: 'POST',
					data: {cccID:cccID},
					dataType: 'html'
				}).done(function(data){
					$("#tempModal").html(data);
					setTimeout(function(){
						$("#splitModal").modal('show');
					},500);

					//console.log(data);
					//location.reload();


				}).fail(function(){
					alert("Hiba!");
				});
			}
			$("#takePlaceYes").click(function(e){
				var type = <?php echo ($compType["technical"]=="t"?"true":"false")?>;
				var values = [];
				$("input[name='ervenyes[]']").each(function() {
					values.push(parseInt($(this).val()));
				});
				var i =0;
				while(values[i]!=0 && i <values.length){
					i++;
				}
				if(values.length == (i++) || type){

					 $.ajax({
					 url:'Model/contestView/schedule/model_ajax_compTakePlace.php',
					 type: 'POST',
					 data: {compID:<?php echo $_POST["compID"]?>},
					 dataType: 'text'
					 }).done(function(data){
					 //console.log(data);
					 location.reload();


					 }).fail(function(){
					 alert("Hiba!");
					 });

				}
				else {
					alert("Érvénytelen verseny számok vannak jelen!");
				}

			});
			function seqUp(aID,rowID){
				$.ajax({
					url:'Model/contestView/schedule/model_ajax_seqUpDown.php',
					type: 'POST',
					data: {aID:aID,
							updateType:"Up",
						rowID:rowID},
					dataType: 'html'
				}).done(function(data){
					if(data.length>0){
						//console.log(data);
						$(rowID).html(data);
					}


				}).fail(function(){
					alert("Hiba!");
				});
			}
			function seqDown(aID,rowID){
				$.ajax({
					url:'Model/contestView/schedule/model_ajax_seqUpDown.php',
					type: 'POST',
					data: {aID:aID,
						updateType:"Down",
						rowID:rowID},
					dataType: 'html'
				}).done(function(data){
					if(data.length>0){
						console.log(data);
						$(rowID).html(data);
					}


				}).fail(function(){
					alert("Hiba!");
				});
			}
		</script>
	<?php
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