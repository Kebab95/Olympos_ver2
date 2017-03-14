<?php
include "../../includeClasses.php";
$DBTasks = new DBTasks();
$requestArray = array();
$org = DBLoad::loadOrg($_POST["orgID"]);
if($org->getType()==2){
	$DBTasks->sqlWithConn('UPDATE org.fed_mship_history SET fh_delete=true,fh_lctime=NOW()
						WHERE fh_club_id='.$_POST["memberID"].' AND fh_id='.$_POST["chID"]);
}
else {
	$DBTasks->sqlWithConn('UPDATE org.club_mship_history SET ch_delete=TRUE ,ch_lctime=NOW()
						WHERE ch_member_id='.$_POST["memberID"].' AND ch_id='.$_POST["chID"]);
}

if($org->getType()==2){
	$DBTasks->sqlWithConn('UPDATE org.fed_mship_history SET fh_current=TRUE ,fh_req_acapted=TRUE,fh_lctime=NOW()
						WHERE fh_club_id='.$_POST["memberID"].' AND fh_id='.$_POST["chID"]);
	$DBTasks->sqlWithConn('UPDATE data.permission SET p_fed_member=TRUE WHERE p_mu_id='.$_POST["memberID"]);

	$requestRes = $DBTasks->sqlWithConn('Select
	  org.fed_mship_history.fh_id,
	  org.fed_mship_history.fh_fed_id,
	  org.fed_mship_history.fh_club_id,
	  data.main_user.mu_name
	From
	  org.fed_mship_history Inner Join
	  data.main_user
	    On org.fed_mship_history.fh_club_id = data.main_user.mu_id
	Where
	  org.fed_mship_history.fh_fed_id = '.$_POST["orgID"].' And
	  org.fed_mship_history.fh_req_acapted = False AND fh_delete=false');
}
else {
	$DBTasks->sqlWithConn('UPDATE org.club_mship_history SET ch_current=TRUE ,ch_req_accepted=TRUE,ch_lctime=NOW()
						WHERE ch_member_id='.$_POST["memberID"].' AND ch_id='.$_POST["chID"]);
	$DBTasks->sqlWithConn('UPDATE data.permission SET p_member=TRUE WHERE p_mu_id='.$_POST["memberID"]);

	$requestRes = $DBTasks->sqlWithConn('Select
  org.club_mship_history.ch_id,
  org.club_mship_history.ch_club_id,
  org.club_mship_history.ch_member_id,
  data.main_user.mu_name
From
  org.club_mship_history Inner Join
  data.main_user
    On org.club_mship_history.ch_member_id = data.main_user.mu_id
Where
  org.club_mship_history.ch_club_id = '.$_POST["orgID"].' And
  org.club_mship_history.ch_req_accepted = False AND ch_delete=false');


	while($row = pg_fetch_row($requestRes, NULL, PGSQL_ASSOC)){
		array_push($requestArray,$row);
	}
}

if(count($requestArray)>0){
	foreach ($requestArray as $item) {
		?>
		<div class="row form-group alert-info" style="padding: 10px">
			<div class="col-md-2 text-center" style="color:#000;">
				<?php echo $item["mu_name"]?>
			</div>
			<?php
			if(isset($item["fh_id"])){
				?>
				<div class="col-md-4">
					<button onclick="showModalOrg(<?php echo $_POST["userID"].",".$item["fh_club_id"]?>)" type="button" class="btn btn-info2 btn-block">Profil</button>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-6">
							<button type="button" class="btn btn-success btn-block" onclick="requestSuccess(<?php echo $item["fh_fed_id"].",".$item["fh_club_id"].",".$item["fh_id"]?>)">Elfogadás</button>
						</div>
						<div class="col-md-6">
							<button type="button" class="btn btn-danger btn-block" onclick="requestDelete(<?php echo $item["fh_fed_id"].",".$item["fh_club_id"].",".$item["fh_id"]?>)">Vissza utasítás</button>
						</div>
					</div>
				</div>
				<?php
			}
			else {
				?>
				<div class="col-md-4">
					<button onclick="showModalProfile(<?php echo UserTasks::getUser()->getId().",".$item["ch_member_id"]?>)" type="button" class="btn btn-info2 btn-block">Profil</button>
				</div>
				<div class="col-md-6">
					<div class="row">
						<div class="col-md-6">
							<button type="button" class="btn btn-success btn-block" onclick="requestSuccess(<?php echo $item["ch_club_id"].",".$item["ch_member_id"].",".$item["ch_id"]?>)">Elfogadás</button>
						</div>
						<div class="col-md-6">
							<button type="button" class="btn btn-danger btn-block" onclick="requestDelete(<?php echo $item["ch_club_id"].",".$item["ch_member_id"].",".$item["ch_id"]?>)">Vissza utasítás</button>
						</div>
					</div>
				</div>
				<?php
			}
			?>

		</div>
		<?php
	}
}
else {
	?>
	<div class="row form-group">
		<div class="col-md-12 text-center">
			Nincsnek jelentkezési szándékok
		</div>
	</div>
	<?php
}