<?php
include "../includeClasses.php";
$DBTasks = new DBTasks();
//var_dump($_POST);

$pswRes = $DBTasks->sqlWithConn('SELECT count(*) as szam FROM data.main_user
						WHERE mu_id='.$_POST["userId"].' AND mu_pass=\''.md5($_POST["UserPwd"]).'\'');
$pwd = pg_fetch_row($pswRes,NULL,PGSQL_ASSOC)["szam"];
if(!is_null($pwd) && $pwd>0){
	$error = false;
	$miss = false;
	if($_POST["userName"] !="" && $_POST["userTelefon"] !=""){
		$update1= $DBTasks->sqlWithConn('UPDATE data.main_user
				SET mu_name = \''.$_POST["userName"].'\',mu_lctime=NOW() WHERE mu_id='.$_POST["userId"]);
		if($update1){
			$telefonRes = $DBTasks->sqlWithConn('SELECT mu_telefon_id FROM data.main_user WHERE mu_id='.$_POST["userId"]);
			$telefon = pg_fetch_row($telefonRes,NULL,PGSQL_ASSOC)["mu_telefon_id"];
			$update2 = $DBTasks->sqlWithConn('UPDATE data.telefon_data
				SET td_num = \''.$_POST["userTelefon"].'\' WHERE td_id='.$telefon);
			if($update2){
				if(isset($_POST["userSportWeight"])){
				    if($_POST["userSportWeight"]!="" && is_numeric($_POST["userSportWeight"])){
						$update6 = $DBTasks->sqlWithConn('UPDATE data.member_data SET md_weight='.$_POST["userSportWeight"].' WHERE md_muid='.$_POST["userId"]);

					    $error = !$update6;
				    }
					else {
						$miss=true;
					}
				}
			}
			else {
				$error = true;
			}
		}
		else {
			$error = true;
		}
	}
	else {
		$miss = true;
	}
	if((!$miss && !$error) &&
		(isset($_POST["orgId"]) && isset($_POST["orgName"]) &&
			isset($_POST["orgShortName"]) && isset($_POST["orgTelefon"]) &&
			isset($_POST["orgFax"]) && isset($_POST["orgWebsite"]))){

		foreach ($_POST["orgId"] as $i => $value) {
			if($miss || !$error){

				$orgID = $value;
				$orgName = $_POST["orgName"][$i];
				$orgShortName = $_POST["orgShortName"][$i];
				$orgTelefon = $_POST["orgTelefon"][$i];
				$orgFax = $_POST["orgFax"][$i];
				$orgWebsite = $_POST["orgWebsite"][$i];

				if($orgName!="" && $orgShortName!="" && $orgTelefon!=""){
					$update3 = $DBTasks->sqlWithConn('UPDATE data.main_user SET mu_name=\''.$orgName.'\',mu_lctime=NOW() WHERE mu_id='.$orgID);
					if($update3){
						$telefonRes = $DBTasks->sqlWithConn('SELECT mu_telefon_id FROM data.main_user WHERE mu_id='.$orgID);
						$telefon = pg_fetch_row($telefonRes,NULL,PGSQL_ASSOC)["mu_telefon_id"];

						$update2 = $DBTasks->sqlWithConn('UPDATE data.telefon_data
											SET td_num = \''.$orgTelefon.'\' WHERE td_id='.$telefon);

						$error = !$update2;
						if(!$error){
						    $update4 = $DBTasks->sqlWithConn('UPDATE org.org_data SET org_shor_name=\''.$orgShortName.'\', org_website=\''.$orgWebsite.'\' WHERE org_mu_id='.$orgID);

							$error = !$update4;
							if(!$error){
								if($orgFax!=""){
									$sql = 'SELECT org_fax_id FROM org.org_data WHERE org_mu_id='.$orgID;
									$faxRes = $DBTasks->sqlWithConn($sql);
									$fax = pg_fetch_row($faxRes,NULL,PGSQL_ASSOC)["org_fax_id"];

									//echo $sql;
									$update5 = $DBTasks->sqlWithConn('UPDATE data.telefon_data
											SET td_num = \''.$orgTelefon.'\' WHERE td_id='.$fax);
									$error = !$update5;
								}

							}

						}
					}
					else {
						$error = true;
					}
				}
				else {
					$miss = true;
				}
			}
			else {
				break;
			}

		}

	}

	if($miss || $error){
	    if($miss){
	        echo "3";
	    }
		if($error){
		    echo "4";
		}
	}
	else{
		echo "2";
	}

}
else {
	echo "1";
}
