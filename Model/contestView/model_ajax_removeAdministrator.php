<?php
include "../../includeClasses.php";
$DBTasks = new DBTasks();
$DBTasks->sqlWithConn('UPDATE '.DBData::getAdministratorTable()." SET ad_delete = true,ad_lctime=NOW() WHERE ".DBData::$adminID." = ".$_POST["adminID"]);

$administratorResult = $DBTasks->selectGetResult(DBData::getAdministratorTable(),DBData::$adminName.",".DBData::$adminID.",".DBData::$adminGenCode,DBData::$adminConrestID."=".$_POST["contestID"]." AND ad_delete=false");
$administratorArray = array();
while($row = pg_fetch_row($administratorResult, NULL, PGSQL_ASSOC)){
	array_push($administratorArray,$row);
}
if(count($administratorArray)>0){
	foreach ($administratorArray as $admin) {
		?>
		<div class="row">
			<div class="col-md-6"><?php echo $admin[DBData::$adminName] ?></div>
			<div class="col-md-3"><?php echo $admin[DBData::$adminGenCode] ?></div>
			<div class="col-md-3"><span onclick="removeAdmin(<?php echo $admin[DBData::$adminID]?>)" class="glyphicon glyphicon-remove"></span> </div>
		</div>
		<?php
	}
	echo "<hr>";
}