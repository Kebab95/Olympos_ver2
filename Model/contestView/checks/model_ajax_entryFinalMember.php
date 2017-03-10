<?php

//var_dump($_POST);
if((isset($_POST["compIDs"]) &&
	isset($_POST["compChecks"]) &&
	isset($_POST["memberId"]) &&
	isset($_POST["defaultVal"]) &&
	isset($_POST["memberWeight"]) &&
	isset($_POST["defaultWeight"])) &&
	(strlen($_POST["memberId"])>0 &&
			$_POST["memberWeight"]>0 &&
			$_POST["memberWeight"]>0)){

	include "../../../includeClasses.php";
	$DBTasks = new DBTasks();
	DBLoad::init();

	if(strcmp($_POST["defaultWeight"],$_POST["memberWeight"])!=0){
		$DBTasks->update(DBData::getMemberDataTable(),
				DBData::$memberDataWeight."=".$_POST["memberWeight"].",
				".DBData::$memberDataLastChangeTime."=NOW()",
				DBData::$memberDataMuID."=".$_POST["memberId"]);
	}
	$User = newLoadUser($_POST["memberId"]);
	$DBTasks->Connect();
	$error = false;
	for($i=0; $i<count($_POST["compIDs"]); $i++){
		$DBTasks->Connect();
		$typesDBResult = $DBTasks->sql("Select
		  contest.comp_types.comp_types_fighting_event,
		  contest.comp_types.comp_types_technical_event,
		  contest.comp_types.comp_types_group_event
		From
		  contest.competetions Inner Join
		  contest.comp_types
		    On contest.competetions.type_id = contest.comp_types.comp_types_id
		Where
		  contest.competetions.comp_id = ".$_POST["compIDs"][$i]);
		$DBTasks->ConnClose();
		$typesDB = pg_fetch_row($typesDBResult, NULL, PGSQL_ASSOC);


		$defaultCheck = $_POST["defaultVal"][$i]=="true";
		$userCheck = $_POST["compChecks"][$i]=="true";
		if($userCheck){
			$catID = getCatId($typesDB,$_POST["compIDs"][$i],$User->getSexFlag(),$User->getAge(),$User->getWeight(),$User->getKnowLedgeId());
		    if($defaultCheck != $userCheck){
				if($catID!=null){
					$DBTasks->Connect();
					$tempSeqResult =$DBTasks->sql('Select
						  contest.assignment.a_seq
						From
						  contest.assignment Inner Join
						  contest.contest_comp
						    On contest.assignment.a_ccc_id = contest.contest_comp.ccc_id
						Where
						  contest.contest_comp.ccc_id = '.$catID.'
						Order By
						  contest.assignment.a_seq Desc
						  LIMIT 1');
					$DBTasks->ConnClose();
					$tempSeq = pg_fetch_row($tempSeqResult, NULL, PGSQL_ASSOC);
					if(!isset($tempSeq["a_seq"])){
						$tempSeq["a_seq"]=0;
					}
					$DBTasks->Connect();
					$insert=$DBTasks->sql('INSERT INTO contest.assignment (a_muid,a_ccc_id,a_orgid,a_seq) VALUES
									('.$User->getId().','.$catID.','.$_POST["orgId"].','.(intval($tempSeq["a_seq"])+1).')');
					$DBTasks->ConnClose();
					if(!$insert){
					    echo "false";
					}
					else {
						$DBTasks->Connect();
						$upinsert = $DBTasks->sql('SELECT contest.datachecks_update_insert(
						    '.$_POST["memberId"].',
						    '.$_POST["orgId"].',
						    '.$_POST["compIDs"][$i].',
						    '.$_POST["contestID"].',
						    true,
						    true,
						    true,
						    true)');
						$DBTasks->ConnClose();
						if(!$upinsert){
							$error=true;
						}
					}
				}
			    else {
				    $error=true;
			    }


		    }
			else {
				if($catID!=null){
					$DBTasks->Connect();
					$tempSeqResult =$DBTasks->sql('Select
						  contest.assignment.a_seq
						From
						  contest.assignment Inner Join
						  contest.contest_comp
						    On contest.assignment.a_ccc_id = contest.contest_comp.ccc_id
						Where
						  contest.contest_comp.ccc_id = '.$catID.'
						Order By
						  contest.assignment.a_seq Desc
						  LIMIT 1');
					$DBTasks->ConnClose();
					$tempSeq = pg_fetch_row($tempSeqResult, NULL, PGSQL_ASSOC);
					if(!isset($tempSeq["a_seq"])){
						$tempSeq["a_seq"]=0;
					}
					$DBTasks->Connect();
					$insert=$DBTasks->sql('INSERT INTO contest.assignment (a_muid,a_ccc_id,a_orgid,a_seq) VALUES
									('.$User->getId().','.$catID.','.$_POST["orgId"].','.(intval($tempSeq["a_seq"])+1).')');
					$DBTasks->ConnClose();
					if(!$insert){
						echo "false";
					}
					else {
						$DBTasks->Connect();
						$upinsert = $DBTasks->sql('SELECT contest.datachecks_update_insert(
						    '.$_POST["memberId"].',
						    '.$_POST["orgId"].',
						    '.$_POST["compIDs"][$i].',
						    '.$_POST["contestID"].',
						    true,
						    true,
						    true,
						    true)');
						$DBTasks->ConnClose();
						if(!$upinsert){
							$error=true;
						}
					}
				}
				else {
					$error=true;
				}
				//echo "Maradt becsekkelve";
			}

		}
		else {
			//Ez akkor fog lefutni ha egy true chekbox false-ra változott
			if($defaultCheck != $userCheck){
				//echo "Kicsekkelte";
				$DBTasks->Connect();
				$DBTasks->sql('SELECT contest.datachecks_update_insert(
						    '.$_POST["memberId"].',
						    '.$_POST["orgId"].',
						    '.$_POST["compIDs"][$i].',
						    '.$_POST["contestID"].',
						    false,
						    false,
						    false,
						    false)');
				$DBTasks->ConnClose();
			}
		}


	}
	$DBTasks->ConnClose();
	if($error){
		echo "false";
	}
	else {
		echo "<td>".$User->getName()."</td>";
		echo "<td>".$User->getWeight()."</td>";
		echo "<td>".$User->getBeltGrades()."</td>";
		echo "<td>".$User->getAge()."</td>";
		for($i=0; $i<count($_POST["compIDs"]); $i++){
			echo "<td><input type='checkbox' disabled id='check".$_POST["compIDs"][$i].$User->getId()."' ".($_POST["compChecks"][$i]=="true"?"checked":"")."></td>";
		}
		echo "<td>";
		echo "<button type='button' class='btn btn-info2 btn-block'>Feloldás</button>";
		echo "</td>";
	}
	/*




	*/
}
else {

}
function newLoadUser($id){
	$DBTasks = new DBTasks();
	$row = $DBTasks->select(DBData::getMainUserTable(),
			"*",
			DBData::$mainUserID." = ".$id ,
			"Left JOIN ".DBData::getEmailDataTable()." ON
                            ".DBData::getMainUserTable().".".DBData::$mainUserEmailID."=
                            ".DBData::getEmailDataTable().".".DBData::$emailDataID."
            Left JOIN ".DBData::getTelefonDataTable()." ON
                            ".DBData::getMainUserTable().".".DBData::$mainUserTelefonID."=
                            ".DBData::getTelefonDataTable().".".DBData::$telefonDataID."
            Left Join
				  data.member_data
				    On data.member_data.md_muid = data.main_user.mu_id Left Join
				  data.belt_grades_data
				    On data.member_data.md_beltgradesid = data.belt_grades_data.bgd_id");
	if($row){
		if(isset($row[DBData::$memberDataID])){
			$user = SportUser::createWithDB($row);
		}
		else {
			$user = User::createWithDB($row);
		}

		$user =$DBTasks->refreshUserPermission($user);
		return $user;
	}
	else {
		return null;
	}
}
/**
 * @return integer
 */
function getCatId($type,$compID,bool $sex,$age,$weight,$knowledge){
	$DBTasks = new DBTasks();
	$DBTasks->Connect();
	if($type[DBData::getCompTypesFlag(0)] =="t"){
		$cccTableID = $DBTasks->sql('Select
					  contest.contest_comp.ccc_id
					From
					  contest.comp_category Inner Join
					  contest.contest_comp
					    On contest.contest_comp.ccc_cat_id = contest.comp_category.compcat_id
					  Inner Join
					  contest.age_group
					    On contest.comp_category.age_grp_id = contest.age_group.age_grp_id
					  Inner Join
					  contest.personal_group
					    On contest.comp_category.personal_grp_id =
					    contest.personal_group.personal_id
					Where
					  contest.contest_comp.ccc_comp_id = '.$compID.' And
					  contest.comp_category.'.($sex?'"sexMan"':'"sexWoman"').' = true And
					  contest.age_group.min <= '.$age.' And
					  contest.age_group.max >= '.$age.' And
					  contest.personal_group.personal_weightmin <= '.$weight.' And
					  contest.personal_group.personal_weightmax >= '.$weight);
		$temp = array();
		while($row = pg_fetch_row($cccTableID, NULL, PGSQL_ASSOC)){
			array_push($temp,$row[DBData::$connCCC_Id]);
		}
		$DBTasks->ConnClose();
		return $temp[0];
	}
	else if($type[DBData::getCompTypesFlag(1)] =="t"){
		$cccTableID = $DBTasks->sql('Select
			  contest.contest_comp.ccc_id
			From
			  contest.entry Inner Join
			  contest.contest_comp
			    On contest.entry.en_compid = contest.contest_comp.ccc_comp_id Inner Join
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
			  contest.entry.en_compid = '.$compID.' And
			  contest.comp_category.'.($sex?'"sexMan"':'"sexWoman"').' = True And
			  contest.age_group.min <= '.$age.' And
			  contest.age_group.max >= '.$age.' And
			  contest.personal_group.personal_knowledge_id = '.$knowledge);
		$temp = array();
		while($row = pg_fetch_row($cccTableID, NULL, PGSQL_ASSOC)){
			array_push($temp,$row[DBData::$connCCC_Id]);
		}
		$DBTasks->ConnClose();
		return $temp[0];
	}else {
		$DBTasks->ConnClose();
		return null;
	}

}
/*
 *
 * if($typesDB[DBData::getCompTypesFlag(0)] =="t"){
			$cccTableID = $DBTasks->sql('Select
					  contest.contest_comp.ccc_id
					From
					  contest.comp_category Inner Join
					  contest.contest_comp
					    On contest.contest_comp.ccc_cat_id = contest.comp_category.compcat_id
					  Inner Join
					  contest.age_group
					    On contest.comp_category.age_grp_id = contest.age_group.age_grp_id
					  Inner Join
					  contest.personal_group
					    On contest.comp_category.personal_grp_id =
					    contest.personal_group.personal_id
					Where
					  contest.contest_comp.ccc_comp_id = '.$_POST["compIDs"][$i].' And
					  contest.comp_category.'.($User->getSexFlag()?'"sexMan"':'"sexWoman"').' = true And
					  contest.age_group.min <= '.$User->getAge().' And
					  contest.age_group.max >= '.$User->getAge().' And
					  contest.personal_group.personal_weightmin <= '.$User->getWeight().' And
					  contest.personal_group.personal_weightmax >= '.$User->getWeight());
			while($row = pg_fetch_row($cccTableID, NULL, PGSQL_ASSOC)){
				echo $row[DBData::$connCCC_Id];
			}
		}
		else {

		}
 */