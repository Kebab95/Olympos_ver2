<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4 text-center"><label>Mérlegelés</label></div>
	<div class="col-md-4"></div>
</div>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<select class="form-control" onchange="changeTableData(this.value)">
			<?php
			foreach ($orgArray as $orgItem) {
				echo "<option value='".$orgItem[DBData::$entryorgID]."'>".$orgItem[DBData::$mainUserName]."</option>";
			}
			?>
		</select>
	</div>
	<div class="col-md-4"></div>
</div>
<hr>
<div class="table-responsive">
<table class="table table-bordered table-striped table-hover">
	<thead style="background-color: #34618C">
	<td style="vertical-align:bottom">Név</td>
	<td style="vertical-align:bottom;width: 150px">Súly</td>
	<td style="vertical-align:bottom;width: 100px">Övfokozat</td>
	<td style="vertical-align:bottom;width: 100px">Életkor</td>
	<?php
	/** @var Competetion $comp */
	foreach ($CompArray as $comp) {
		echo "<td class='vertical-header'><div class='vertical-header'><strong>".$comp->getTitle()."</strong></div></td>";
	}
	?>
	<td style="width: 100px"></td>
	</thead>
	<tbody id="tableMemberData">

	<?php
	foreach ($User as $item) {

		if($item["Deliberation"]){
			echo "<tr style='background-color: #3e8f3e'>";
			/** @var SportUser $tempUser */
			$tempUser = $item["User"];
			echo "<td>".$tempUser->getName()."</td>";
			echo "<td>".$tempUser->getWeight()."</td>";
			echo "<td>".$tempUser->getBeltGrades()."</td>";
			echo "<td>".$tempUser->getAge()."</td>";
			$tempCompArray = array();
			foreach ($CompArray as $comp) {
				array_push($tempCompArray,$comp->getId());
				echo "<td><input type='checkbox' disabled id='check".$comp->getId().$tempUser->getId()."' ".($item[$comp->getId()]?"checked":"")."></td>";
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
			foreach ($CompArray as $comp) {
				array_push($tempCompArray,$comp->getId());
				echo "<td><input type='checkbox' id='check".$comp->getId().$tempUser->getId()."' ".($item[$comp->getId()]?"checked":"")."></td>";
				//echo "<td class='vertical-header'><div class='vertical-header'><strong>".$comp->getTitle()."</strong></div></td>";
			}
			echo "<td>";
			$defaultVal = array();
			foreach ($tempCompArray as $value) {
				array_push($defaultVal,$item[$value]);
			}
			echo "<input type='hidden' id='memberOrgId".$tempUser->getId()."' value='".$orgArray[0][DBData::$entryorgID]."'>";
			echo "<input type='hidden' id='defaultValue".$tempUser->getId()."' value='".json_encode($defaultVal)."'>";
			echo "<button type='button' onclick='entryFinalization(".$tempUser->getId().")' class='btn btn-success btn-block'>Véglegesítés</button>";
			echo "</td>";
			echo "</tr>";
		}


	}
	?>
	</tbody>
</table>
</div>
<input type="hidden" value='<?php echo json_encode($tempCompArray)?>' id="jsonCompIDs">
<script>
	function changeTableData(orgID){
		var compIDs = JSON.parse($("#jsonCompIDs").val());
		$.ajax({
			url:'Model/contestView/checks/model_ajax_changeTableData.php',
			type: 'POST',
			data: {compIds:compIDs,
					contestID: <?php echo $_GET["contestview"]?>,
					orgId:orgID},
			dataType: 'html'
		}).done(function(data){
			//console.log(data);
			$('#tableMemberData').html(data);
		}).fail(function(){
			alert("Hiba!");
		});
	}
	function entryFinalization(memberId){
		var compIDs = JSON.parse($("#jsonCompIDs").val());
		//console.log(compIDs);
		var compCheckBoxArrayData = new Array();
		var defaultVal= JSON.parse($("#defaultValue"+memberId).val());
		compIDs.forEach(function(item){
			compCheckBoxArrayData.push($('#check'+item+""+memberId).is(':checked'));
		});
		var memberWeight= parseInt($("#memberWeight"+memberId).val());
		var defaultWeight= parseInt($("#defaultWeight"+memberId).val());
		var orgId = $("#memberOrgId"+memberId).val();
		$.ajax({
			url:'Model/contestView/checks/model_ajax_entryFinalMember.php',
			type: 'POST',
			data: {compIDs: compIDs,
					compChecks: compCheckBoxArrayData,
					memberId: memberId,
					defaultVal: defaultVal,
					memberWeight: memberWeight,
					defaultWeight: defaultWeight,
					orgId: orgId,
					contestID: <?php echo $_GET["contestview"]?>},
			dataType: 'html'
		}).done(function(data){
			console.log(data);
			$('#memberRow'+memberId).html(data);
			$('#memberRow'+memberId).css('background-color','#3e8f3e');
			/*

			*/
		}).fail(function(){
			alert("Hiba!");
		});
		//console.log(compCheckBoxArrayData[0]);
	}
</script>