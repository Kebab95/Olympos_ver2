<?php
include "../../../includeClasses.php";
$DBTasks = new DBTasks();
DBLoad::init();
$allRes = $DBTasks->sqlWithConn('Select
  *
From
  contest.contest_comp Inner Join
  contest.comp_category
    On contest.contest_comp.ccc_cat_id = contest.comp_category.compcat_id
  Inner Join
  contest.personal_group
    On contest.comp_category.personal_grp_id =
    contest.personal_group.personal_id Inner Join
  contest.age_group
    On contest.comp_category.age_grp_id = contest.age_group.age_grp_id WHERE ccc_id='.$_POST["cccID"]);
$all =pg_fetch_row($allRes, NULL, PGSQL_ASSOC);
$catOne = CompCategory::createWithDB($all);
$result = $DBTasks->sqlWithConn('Select
  contest.contest_comp.ccc_division,
  contest.comp_category.compcat_id,
  contest.comp_category.compcat_org_id,
  contest.comp_category.fed_cost1,
  contest.comp_category.fed_cost2,
  contest.comp_category.nonfed_cost1,
  contest.comp_category.nonfed_cost2,
  contest.comp_category.foreign_cost1,
  contest.comp_category.foreign_cost2,
  contest.comp_category.sex,
  contest.comp_category."sexWoman",
  contest.comp_category."sexMan",
  contest.comp_category."sexMixed",
  contest.comp_category."groupFight",
  contest.age_group.age_grp_comp_id,
  contest.age_group.min,
  contest.age_group.max,
  contest.age_group.age_grp_comp_type_id,
  contest.personal_group.personal_title,
  contest.personal_group.personal_weightmin,
  contest.personal_group.personal_weightmax,
  contest.personal_group.personal_knowledge_id,
  contest.personal_group.personal_comp_types_id,
  contest.contest_comp.ccc_id
From
  contest.contest_comp Inner Join
  contest.assignment
    On contest.assignment.a_ccc_id = contest.contest_comp.ccc_id Inner Join
  contest.comp_category
    On contest.contest_comp.ccc_cat_id = contest.comp_category.compcat_id
  Inner Join
  contest.personal_group
    On contest.comp_category.personal_grp_id =
    contest.personal_group.personal_id Inner Join
  contest.age_group
    On contest.comp_category.age_grp_id = contest.age_group.age_grp_id WHERE ccc_comp_id='.$all["ccc_comp_id"].'
Group By
  contest.contest_comp.ccc_comp_id, contest.contest_comp.ccc_division,
  contest.comp_category.compcat_id, contest.comp_category.compcat_org_id,
  contest.comp_category.fed_cost1, contest.comp_category.fed_cost2,
  contest.comp_category.nonfed_cost1, contest.comp_category.nonfed_cost2,
  contest.comp_category.foreign_cost1, contest.comp_category.foreign_cost2,
  contest.comp_category.sex, contest.comp_category."sexWoman",
  contest.comp_category."sexMan", contest.comp_category."sexMixed",
  contest.comp_category."groupFight", contest.age_group.age_grp_comp_id,
  contest.age_group.min, contest.age_group.max,
  contest.age_group.age_grp_comp_type_id, contest.personal_group.personal_title,
  contest.personal_group.personal_weightmin,
  contest.personal_group.personal_weightmax,
  contest.personal_group.personal_knowledge_id,
  contest.personal_group.personal_comp_types_id, contest.contest_comp.ccc_id
  Order By
  contest.comp_category.compcat_id,
  contest.contest_comp.ccc_division');
$array = array();
$index = 0;
while($row =pg_fetch_row($result, NULL, PGSQL_ASSOC)){
	$array[$index][0] = CompCategory::createWithDB($row);
	$array[$index][1] = $row["ccc_division"];
	$array[$index][2] = $row["ccc_id"];
	$index++;
}
?>
<div class="modal fade" id="splitModal" role="dialog">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				Össevonás
			</div>
			<div class="modal-body">
				<div class="row form-group">
					<div class="col-md-12 text-center">
						Kategória összevonás. Kérem válassza ki melyik kategóriába szeretné összevonni. Kategóriában lévő összes tag át kerül a kiválasztott kategóriába
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-6">Kategóra név</div>
					<div class="col-md-6">Ahová akara össze vonni</div>
				</div>
				<div class="row form-group">
					<div class="col-md-6"><?php echo $catOne.", Divizió: ".UserTasks::getDivision_toString($all["ccc_division"])?></div>
					<div class="col-md-6">
						<select class="form-control" id="selectCCCId">
							<?php
							foreach ($array as $item) {
								/** @var CompCategory $tempCat */
								$tempCat = $item[0];
								echo "<option value='".$item[2]."'>".$tempCat.", Divizió: ".UserTasks::getDivision_toString($item[1])."</option>";
							}
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="row">
					<div class="col-xs-6"><button class="btn btn-success btn-block" id="massSubmit">Véglegesítés</button> </div>
					<div class="col-xs-6"><button class="btn btn-danger" data-dismiss="modal">Bezárás</button></div>
				</div>

			</div>
		</div>
	</div>
</div>
<script>
	$("#massSubmit").click(function (e){
		$.ajax({
			url:'Model/contestView/schedule/model_ajax_massSubmit.php',
			type: 'POST',
			data: {defaultCCCId:<?php echo $_POST["cccID"]?>,newCCCId:$("#selectCCCId").val()},
			dataType: 'html'
		}).done(function(data){
			//console.log(data);
			location.reload();

		}).fail(function(){
			alert("Hiba!");
		});
	});
</script>