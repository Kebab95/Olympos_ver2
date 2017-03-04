<?php
include "../../includeClasses.php";
$DBTasks = new DBTasks();
DBLoad::init();
//var_dump($_POST);

if(     isset($_POST["ageSelect"])
		&& isset($_POST["groupSelect"])
		&& (($_POST["sex0"]=="true")
		|| ($_POST["sex1"]=="true")
		|| ($_POST["sex2"]=="true"))
		&& isset($_POST["groupFight"])
		&& isset($_POST["fedcost1"])
		&& isset($_POST["fedcost2"])
		&& isset($_POST["nonfedcost1"])
		&& isset($_POST["nonfedcost2"])
		&& isset($_POST["foreigncost1"])
		&& isset($_POST["foreigncost2"])
		&& isset($_POST["org_id"])
		&& isset($_POST["comp_id"])
		&& isset($_POST["contest_id"])){
	if($_POST["personalType"]=="1"){
		$values = "(".$_POST["groupSelect"][0];
		if(count($_POST["groupSelect"])>1){
			for($i=1; $i<count($_POST["groupSelect"]); $i++){
				$values.=",".$_POST["groupSelect"][$i];
		}
		}
		unset($_POST["groupSelect"]);
		$_POST["groupSelect"] = array();

		$values.=")";
		$asd = $DBTasks->selectGetResult(DBData::getKnowLedgeTable(),"*",DBData::$knowLedgeId." in ".$values);
		while($row = pg_fetch_row($asd, NULL, PGSQL_ASSOC)){
			$temp = $DBTasks->insert(DBData::getPersonalGroupTable(),
					DBData::$personalGrpTitle.",".DBData::$personalGrpCompID.",".DBData::$personalGrpTypeID.",".DBData::$personalGrpknowLEdgeID,
					"'".$row[DBData::$knowLedgeName]."',".$_POST["comp_id"].",".$_POST["comp_type"].",".$row[DBData::$knowLedgeId],"returning ".DBData::$personalGrpID);
			$row2 = pg_fetch_row($temp, NULL, PGSQL_ASSOC);
			array_push($_POST["groupSelect"],$row2[DBData::$personalGrpID]);
		}

	}
	//var_dump($_POST["groupSelect"]);

	$values ="";
	for($i=0; $i<count($_POST["ageSelect"]); $i++){
	    for($j=0; $j<count($_POST["groupSelect"]); $j++){
			$temp ="";
		    $temp.="(".$_POST["org_id"].",
		    ".$_POST["ageSelect"][$i].",
		    ".$_POST["groupSelect"][$j].",
		    ".$_POST["sex0"].",
		    ".$_POST["sex1"].",
		    ".$_POST["sex2"].",
		    ".$_POST["groupFight"].",
		    ".$_POST["fedcost1"].",
		    ".$_POST["fedcost2"].",
		    ".$_POST["nonfedcost1"].",
		    ".$_POST["nonfedcost2"].",
		    ".$_POST["foreigncost1"].",
		    ".$_POST["foreigncost2"].")";
		    /*
			if($_POST["sex0"]=="true"){
			    $temp.="(".$_POST["org_id"].",".$_POST["ageSelect"][$i].", ".$_POST["groupSelect"][$j].", 1,".$_POST["fedcost1"].",".$_POST["fedcost2"].",".$_POST["nonfedcost1"].",".$_POST["nonfedcost2"].",".$_POST["foreigncost1"].",".$_POST["foreigncost2"].")";
			}
		    if($_POST["sex1"] =="true"){
				if(strlen($temp)>0){
					$temp.=",";
				}
			    $temp.="(".$_POST["org_id"].",".$_POST["ageSelect"][$i].", ".$_POST["groupSelect"][$j].", 2,".$_POST["fedcost1"].",".$_POST["fedcost2"].",".$_POST["nonfedcost1"].",".$_POST["nonfedcost2"].",".$_POST["foreigncost1"].",".$_POST["foreigncost2"].")";

		    }
		    if($_POST["sex2"] =="true"){
			    if(strlen($temp)>0){
				    $temp.=",";
			    }
			    $temp.="(".$_POST["org_id"].",".$_POST["ageSelect"][$i].", ".$_POST["groupSelect"][$j].", 3,".$_POST["fedcost1"].",".$_POST["fedcost2"].",".$_POST["nonfedcost1"].",".$_POST["nonfedcost2"].",".$_POST["foreigncost1"].",".$_POST["foreigncost2"].")";

		    }
		    if($_POST["groupFight"] =="true"){
			    if(strlen($temp)>0){
				    $temp.=",";
			    }
			    $temp.="(".$_POST["org_id"].",".$_POST["ageSelect"][$i].", ".$_POST["groupSelect"][$j].", 4,".$_POST["fedcost1"].",".$_POST["fedcost2"].",".$_POST["nonfedcost1"].",".$_POST["nonfedcost2"].",".$_POST["foreigncost1"].",".$_POST["foreigncost2"].")";

		    }
		    */

		    if(strlen($values)>0){
				$values.=",";
		    }
		    $values.=$temp;
	    }
	}

	$DBTasks->Connect();
	$sql ="INSERT INTO ".DBData::getCompCategoryTable()." (
							".DBData::$compCatOrgID.",
						".DBData::$compCatAgeGrpID.",
						".DBData::$compCatPersonalGrpID.",
						\"".DBData::$compCatSexMan."\",
						\"".DBData::$compCatSexWoman."\",
						\"".DBData::$compCatSexMixed."\",
						\"".DBData::$compCatGroupFight."\",
						".DBData::$compCatFed_cost1.",
						".DBData::$compCatFed_cost2.",
						".DBData::$compCatnonFed_cost1.",
						".DBData::$compCatnonFed_cost2.",
						".DBData::$compCatForeign_cost1.",
						".DBData::$compCatForeign_cost2.")
					VALUES ".$values." returning ".DBData::$compCatID.";";
	$result = $DBTasks->sql($sql);
	if(pg_num_rows($result)>0){
		$sqlUpdate ="update ".DBData::getConnectionCCCTable()." SET ".DBData::$connCCC_Delete."=true WHERE ".DBData::$connCCC_ContestID."=25 AND ".DBData::$connCCC_CompID."=26 AND ".DBData::$connCCC_CatID." IS NULL;";
		$DBTasks->sql($sqlUpdate);

		$cccValues="";
		while($row = pg_fetch_row($result, NULL, PGSQL_ASSOC)){
			if(strlen($cccValues)>0){
			    $cccValues.=",";
			}
			$cccValues.="(".$_POST["contest_id"].",".$_POST["comp_id"].",".$row[DBData::$compCatID].")";
		}

		$sqlCCC="INSERT INTO ".DBData::getConnectionCCCTable()." (
					".DBData::$connCCC_ContestID.",
					".DBData::$connCCC_CompID.",
					".DBData::$connCCC_CatID."
		) VALUES ".$cccValues." returning ".DBData::$connCCC_Id.";";

		$resultCCC = $DBTasks->sql($sqlCCC);
		if(pg_num_rows($resultCCC)>0){
			echo "true";
		}
		else {
			echo "false";
		}
	}
	else {
		echo "false";
	}

	$DBTasks->ConnClose();

}
else {
	echo "false";
}
