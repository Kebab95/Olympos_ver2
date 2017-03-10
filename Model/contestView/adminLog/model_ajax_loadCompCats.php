<?php
if($_POST["compID"]!=""){
	include "../../../includeClasses.php";
	$DBTasks = new DBTasks();
	$DBTasks->Connect();
	$result = $DBTasks->sql("Select
  contest.comp_category.*,
  contest.age_group.*,
  contest.personal_group.*,
  contest.contest_comp.ccc_division,
  contest.contest_comp.ccc_id
  From
  contest.contest_comp Inner Join
  contest.comp_category
    On contest.contest_comp.ccc_cat_id = contest.comp_category.compcat_id
  Inner Join
  contest.age_group
    On contest.comp_category.age_grp_id = contest.age_group.age_grp_id
  Inner Join
  contest.personal_group
    On contest.comp_category.personal_grp_id =
    contest.personal_group.personal_id
Where
	contest.contest_comp.ccc_comp_id=".$_POST["compID"]." AND
  contest.contest_comp.ccc_takeplace = True
  Order By
  contest.age_group.min");
	$DBTasks->ConnClose();
	while($row =pg_fetch_row($result, NULL, PGSQL_ASSOC)){
		$tempCat = CompCategory::createWithDB($row);
		$edit = $DBTasks->select("contest_data.admin_edit_cat","contest_data.admin_edit_cat.aec_under_editing AS edit","contest_data.admin_edit_cat.aec_ccc_id = ".$row["ccc_id"],null,"Group By
  contest_data.admin_edit_cat.aec_under_editing");
		?>
			<hr>
		<div class="panel panel-default">
			<div class="panel-heading">
				<div class="row">
					<div class="col-md-6">
						<?php echo $tempCat?>, Divizió: <?php echo UserTasks::getDivision_toString($row["ccc_division"])?>
					</div>
					<div class="col-md-6">
						<button class="btn <?php echo (isset($edit["edit"]) && $edit["edit"]=="t"?"btn-danger":"btn-success")?> btn-block" <?php echo (isset($edit["edit"]) && $edit["edit"]=="t"?"disabled":"")?> onclick="adminOpenCategory(<?php echo $_POST["adminID"] .",".$row["ccc_id"]?>)">Szerkesztés</button>
					</div>
				</div>

			</div>

			<?php echo (isset($edit["edit"]) && $edit["edit"]=="t"?'<div class="panel-body">
				<div class="text-center">Szerkesztés alatt</div>
			</div>':"")?>
		</div>
		<?php
	}
}
else {

}

