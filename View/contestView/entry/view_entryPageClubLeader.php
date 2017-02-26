<?php
/** @var Organization $ClubOrg */
/** @var User $clubMember */
?>
<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading text-center">
				<h3>Nevezés</h3>
				<h4><?php echo $contestName?></h4>
				<h5><?php echo $ClubOrg->getName()?></h5>
			</div>
			<div class="panel-body">

			</div>
			<form action=""method="post" id="entryMembers">
			<table class="table table-bordered table-responsive">
				<thead>
					<td>Név</td>
					<td width="200px">Súly</td>
					<td>Öv szint</td>
					<td width="200px"></td>
				</thead>
				<tbody>
					<?php
					$id = 0;
					foreach ($ClubMembers as $clubMember) {
						$typeMember = SportUser::isSportUser($clubMember);
						echo "<tr id='memberRow".$clubMember->getId()."'>";
						echo "<td><a onclick='showModalProfile(".UserTasks::getUser()->getId().",".$clubMember->getId().")'>".$clubMember->getName()."</a></td>";
						if($typeMember){
							/** @var SportUser $sportClubMember */
							$sportClubMember = $clubMember;
							echo "<td>".$sportClubMember->getWeight()."</td>";
							echo "<td>".$sportClubMember->getBeltGrades()."</td>";
							echo "<td><label>Ki választ</label>
								<input value='".$clubMember->getId()."' name='memberArray[]' type='checkbox' id='check".$clubMember->getId()."'></td>";
						}
						else {
							echo "<td colspan='2'  class='text-justify'><label>Ezt a tagot addig nem küldheti versenyre amíg nem egészítette ki a megfelelő adatokkal</label></td>";
							echo "<td><button type='button' class='btn btn-block btn-info' data-toggle='modal' data-target='#setMember".$clubMember->getId()."'>Adat kiegészítés</button>".modal($clubMember->getId(),$grades)."</td>";
						}

						echo "</tr>";
						$id++;
					}
					?>
				</tbody>
			</table>
			<div class="panel-footer">
				<div class="row">


					<div class="col-md-12">
						<input type="hidden" value="<?php echo $ClubOrg->getId()?>" name="clubID">
						<input class="btn btn-success btn-block" value="Nevezés" name="memberEntrySubmit" type="submit">
					</div>
					<div class="col-md-12">
						<a href="?contestview=<?php echo $contestID?>"><button type="button" class="btn btn-danger btn-block">Mégse</button></a>
					</div>
				</div>


			</div>
			</form>
		</div>
	</div>
	<div class="col-md-2"></div>
	<script>
		function tesztvalami(id){
			var memberWeight = $("#memberWeight"+id).val();
			var memberBeltGradesID = $("#memberGrades"+id).val();
			var memberRow= "#memberRow"+id;
			var modal ="#setMember"+id;
			$.ajax({
				url:'Model/contestView/entry/model_ajax_UpdateMember.php',
				type: 'POST',
				data: {id: id,
						weight: memberWeight,
						beltgradesID: memberBeltGradesID},
				dataType:'html'
			}).done(function(data){
				console.log(data);
				if(data=="false"){

				}
				else {
					$(modal).modal('toggle');
					setTimeout(
							function()
							{
								var html ="";
								$(memberRow).html(data);
							}, 500);
				}
			}).fail(function(){
				alert("Hiba!");
			});
		}
	</script>
</div>
<?php
function modal($id, array $grades){
	$back="<div class='modal fade' id='setMember".$id."'>";
	$back.="<div class=\"modal-dialog\">";
	$back.="<div class=\"modal-content\">";
	$back.="<div class=\"modal-body\">";
	$back.="<div class='row'>";
	$back.="<div class='col-md-6'>Súly (Kg)</div>";
	$back.="<div class='col-md-6'><input type='number' id='memberWeight".$id."' class='form-control'></div>";

	$back.="<div class='col-md-6'>Öv fokozat</div>";
	$back.="<div class='col-md-6'>";
	$back.="<select class='form-control' id='memberGrades".$id."'>";
	foreach ($grades as $grade) {
		$back.="<option value='".$grade[DBData::$beltGradesID]."'>".$grade[DBData::$beltGradesName]."</option>";

	}
	$back.="</select>";
	$back.="</div>";
	$back.="<div class='col-md-12'>";
	$back.="<button type='button' onclick='tesztvalami(".$id.")' id='memberUpdate".$id."' class='btn btn-success'>Frissítés</button>";
	$back.="</div>";
	$back.="</div>";
	$back .="</div>";
	$back.="<div class=\"modal-footer\">";
	$back.= "<button type=\"button\" class=\"btn btn-default\" data-dismiss=\"modal\">Close</button>";
	$back .="</div>";
	$back .="</div>";
	$back .="</div>";
	return $back;
}