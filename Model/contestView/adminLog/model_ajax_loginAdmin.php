<?php
include "../../../includeClasses.php";
$DBTasks = new DBTasks();
DBLoad::init();
$result = $DBTasks->selectGetResult(DBData::getAdministratorTable(),"*",DBData::$adminGenCode."='".$_POST["code"]."' AND ".DBData::$adminConrestID."=".$_POST["contestID"]." AND ad_delete = false");
if(pg_num_rows($result)>0){
	$row = pg_fetch_row($result, NULL, PGSQL_ASSOC);
	$adminName= $row[DBData::$adminName];
	$adminID= $row[DBData::$adminID];

	$DBTasks->Connect();
	$resultVahanyadik = $DBTasks->sql('Select
		  *
		From
		  contest_data.admin_edit_cat WHERE aec_adminid='.$adminID." AND aec_under_editing=true");
	$DBTasks->ConnClose();
	if(pg_num_rows($resultVahanyadik)>0){
		$row = pg_fetch_row($resultVahanyadik, NULL, PGSQL_ASSOC);
		echo "<script>
				adminOpenCategory(".$row["aec_adminid"].",".$row["aec_ccc_id"].");
			</script>";
	}
	else {
		$contestID = $_POST["contestID"];
		$contestName = DBLoad::loadContest($contestID)->getName();
		$result = $DBTasks->selectGetResult(DBData::getConnectionCCCTable(),DBData::$connCCC_CompID,
				DBData::$connCCC_ContestID."=".$_POST["contestID"]." AND ".DBData::$connCCC_TakePlace."=true Group By ".DBData::$connCCC_CompID);
		$compArray = array();
		while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
			array_push($compArray,DBLoad::loadCompetetion($row[DBData::$connCCC_CompID]));
		}
		$login = true;
		include "../../../View/contestView/adminLog/view_adminView.php";
	}



}
else {
	?>
	<div class="alert alert-danger text-center">
		Helytelen bejelentkezési kód.
	</div>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4">
			<div class="panel panel-default">
				<div class="panel-heading">
					Jegyzői bejelentkezés
				</div>
				<div class="panel-body text-center">
					Kérjük a bejelentkezési kódot:
					<input type="text" class="form-control" id="adminLoginCode">
				</div>
				<div class="panel-footer">
					<button class="btn btn-success btn-block" onclick="adminLogin()">Bejelentkezés</button>
				</div>
			</div>
		</div>
		<div class="col-md-4"></div>
	</div>
	<?php
}