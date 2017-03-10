<?php
include "../../../includeClasses.php";
$DBTasks = new DBTasks();
DBLoad::init();
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
  contest.contest_comp.ccc_id = '.$_POST["cccID"].'
  Order By
  contest.assignment.a_seq');
$userArray = array();
$db = 0;

while($row =pg_fetch_row($result, NULL, PGSQL_ASSOC)){
	$userArray[$db][0] = SportUser::createWithDB($row);
	$userArray[$db][1] = DBLoad::loadOrg($row["a_orgid"]);
	$userArray[$db][2] = $row["ccc_division"];
	$db++;
}
?>
<div class="modal fade" id="splitModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Szétválasztás
			</div>
			<div class="modal-body">
				<div class="row form-group">
					<div class="col-md-12 text-center">
						Kategória szét választása. Válassza ki ki melyik divizióba kerülön
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-4">Név</div>
					<div class="col-md-4">Egyesület</div>
					<div class="col-md-4">Divizió</div>

				</div>
				<div class="row form-group">
					<?php
					foreach ($userArray as $item) {
						/** @var SportUser $tempUser */
						$tempUser = $item[0];
						/** @var Organization $tempOrg */
						$tempOrg = $item[1];
						$tempDivision = $item[2];
						echo "<div class='col-md-4'>".$tempUser->getName()."</div>";
						echo "<div class='col-md-4'>".$tempOrg->getName()."</div>";
						echo "<div class='col-md-4'><select class='form-control' name='division[]' id='division'> ";
						foreach (UserTasks::getDivisionArray() as $key => $value) {
							echo "<option ".($key==$tempDivision?"selected":"")." value='$key'>$value</option>";
						}
						echo "</select><input type='hidden' name='userID[]' value='".$tempUser->getId()."'></div>";
					}
					?>
				</div>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-xs-6"><button class="btn btn-success btn-block" id="splitSubmit">Véglegesítés</button> </div>
					<div class="col-xs-6"><button class="btn btn-danger" data-dismiss="modal">Bezárás</button></div>
				</div>

			</div>
		</div>
	</div>
</div>
<?php
$allRes = $DBTasks->sqlWithConn('SELECT
	ccc_contest_id,
	ccc_comp_id,
	ccc_cat_id
	FROM contest.contest_comp
	WHERE ccc_id='.$_POST["cccID"]);
$all =pg_fetch_row($allRes, NULL, PGSQL_ASSOC)
?>
<script>
	$("#splitSubmit").click(function(){
		var asd= [];
		var userID = [];
		$("select[name='division[]']").each(function(){
			asd.push($(this).val());
		});
		$("input[name='userID[]']").each(function(){
			userID.push($(this).val());
		});
		var count = [];
		console.log(userID);
		asd.forEach(function(value){
			if (count[value] == null){
				count[value] = 1;
			}
			else {
				count[value]++;
			}
		});
		var bool = true;
		count.forEach(function(value){
			if (value==2 || value==3 || value==4 || value==8){

			}
			else {
				bool = false;
			}
		});
		if(bool){
			$.ajax({
				url:'Model/contestView/schedule/model_ajax_splitSubmit.php',
				type: 'POST',
				data: {userIDs: userID, division:asd,
					contestID: <?php echo $all["ccc_contest_id"]?>,compID:<?php echo $all["ccc_comp_id"]?>,
					catID:<?php echo $all["ccc_cat_id"]?>},
				dataType: 'html'
			}).done(function(data){
				location.reload();

			}).fail(function(){
				alert("Hiba!");
			});
		}
		else {
			console.log("Rosz");
		}
	});
</script>