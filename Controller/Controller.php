<?php
if($_POST && !isset($_POST["orgCreateSubmit"])){
	if(isset($_POST["login"])){
		include 'Model/model_defaultUserVerification.php';
		$inBody = "View/Login/view_login.php";
		include 'View/view_default.php';
	}
	else if(isset($_POST["editProfile"])){
		header_remove();
		$_SESSION["collapsOpenProfile"] = true;
		header("Location: ?nav=settings");

	}
	else if(isset($_POST["logout"])){
		header_remove();
		header("Location: ?nav=home");
		unset($_SESSION["User"]);
	}
	else if(isset($_POST["createClub"])){
		include "Model/model_defaultUserVerification.php";
		$orgType= "Club";
		include "Model/model_createOrg.php";
		$inBody = "View/Organization/view_createOrg.php";
		include "View/view_default.php";
	}
	else if(isset($_POST["createFed"])){
		include "Model/model_defaultUserVerification.php";
		$orgType= "Fed";
		include "Model/model_createOrg.php";
		$inBody = "View/Organization/view_createOrg.php";
		include "View/view_default.php";
	}
	else if(isset($_POST["orgJoinSubmit"])){
		include 'Model/model_defaultUserVerification.php';
		include 'Model/OrgPage/model_joinOrg.php';
		$inBody = "View/Organization/view_modalJoinOrg.php";
		include 'View/view_default.php';
	}
	else if(isset($_POST["createRace1"])){
		include "Model/model_defaultUserVerification.php";
		include "Model/Races/model_raceCreateForm2.php";
		//include "Model/Races/model_racesPage.php";
		$inBody = "View/Races/view_raceCreatePanel.php";
		include "View/view_default.php";
	}
	else if(isset($_POST["createRace2"])){
		include "Model/model_defaultUserVerification.php";
		include "Model/Races/model_createComp.php";
		if(isset($error) && $error){
			echo "Nem sikerült";
		}
		else {
			header_remove();
			header("Location: ?contest=list");
		}

	}
	else if(isset($_POST["memberEntrySubmit"])){
		include "Model/model_defaultUserVerification.php";
		include "Model/contestView/entry/model_entrySubmit.php";
		$inBody ="View/contestView/entry/view_entrySubmit.php";
		include "View/view_default.php";

	}

}
/** @var User $_SESSION['User'] */

else if(isset($_GET["nav"])){
	resetSESSIONs();
	switch($_GET["nav"]){
		case 'home':
			include 'Model/model_defaultUserVerification.php';
			include "Model/model_home.php";
			$inBody = "View/view_home.php";
			include 'View/view_default.php';
			break;
		case 'reg':
			include 'Model/model_defaultUserVerification.php';
			$inBody = "View/view_reg.php";
			include 'View/view_default.php';
			break;
		case 'passhelp':
			include 'Model/model_defaultUserVerification.php';
			$inBody = "View/view_forgetPass.php";
			include 'View/view_default.php';
			break;
		case 'fed':

			if(UserTasks::isLoggedUser()){
				include 'Model/model_defaultUserVerification.php';
				include 'Model/OrgPage/model_fedPage.php';
				$inBody = "View/Organization/view_orgPage.php";
				include 'View/view_default.php';
			}
			else {
				header_remove();
				header("Location: ?nav=405");
			}




			break;
		case 'inbox':
			if(UserTasks::isLoggedUser()){
				include 'Model/model_defaultUserVerification.php';
				include 'Model/Inbox/model_inbox.php';
				$inBody = "View/Inbox/view_inbox.php";
				include 'View/view_default.php';
			}
			else {
				header_remove();
				header("Location: ?nav=405");
			}
			break;
		case 'club':

			if(UserTasks::isLoggedUser()){
				include 'Model/model_defaultUserVerification.php';
				include 'Model/OrgPage/model_clubPage.php';
				$inBody = "View/Organization/view_orgPage.php";
				include 'View/view_default.php';
			}
			else {
				header_remove();
				header("Location: ?nav=405");
			}


			break;
		case 'settings':

			if(UserTasks::isLoggedUser()){
				include "Model/model_defaultUserVerification.php";
				include "Model/model_settings.php";

				$inBody = "View/Settings/view_settings.php";
				include "View/view_default.php";
				unset($_SESSION["collapsOpenProfile"]);

			}
			else {
				header_remove();
				header("Location: ?nav=405");
			}


			break;
		case "myclub":
			if(UserTasks::isLoggedUser() && (UserTasks::isMember() || UserTasks::isClubLeader())){
				include "Model/model_defaultUserVerification.php";
				include "Model/myClub/model_myCubPage.php";

				$inBody = "View/myClub/view_myClubPage.php";
				include "View/view_default.php";
			}
			else{
				header_remove();
				header("Location: ?nav=405");
			}
			break;
		case "myfed":
			if(UserTasks::isLoggedUser() && (UserTasks::isFederationMember() || UserTasks::isFederationLeader())){
				include "Model/model_defaultUserVerification.php";
				include "Model/myFed/model_myFed.php";

				$inBody = "View/myFed/view_myFed.php";
				include "View/view_default.php";
			}
			else{
				header_remove();
				header("Location: ?nav=405");
			}
			break;
		case 'races':
			if(UserTasks::isLoggedUser()){
				include "Model/model_defaultUserVerification.php";
				include "Model/Races/model_racesPage.php";
				$inBody = "View/Races/view_racesPage.php";
				include "View/view_default.php";
			}
			else {
				header_remove();
				header("Location: ?nav=405");
			}
			break;
		/*
		case 'logout':
			header_remove();
			header("Location: ?nav=home");
			unset($_SESSION["User"]);
			break;
		*/
		default:
			include "Model/model_defaultUserVerification.php";
			$inBody = "View/view_pageNotFound.php";
			include "View/view_default.php";
	}
}
elseif(isset($_GET["contest"])){
	switch($_GET["contest"]){
		case "create":
			if(UserTasks::isLoggedUser() && (UserTasks::isClubLeader() || UserTasks::isFederationLeader())){
				include "Model/model_defaultUserVerification.php";
				include "Model/Races/model_raceCreateForm.php";
				//include "Model/Races/model_racesPage.php";
				$inBody = "View/Races/view_raceCreatePanel.php";
				include "View/view_default.php";
			}
			else {
				header_remove();
				header("Location: ?nav=405");
			}
			break;
		case "list":
			if(UserTasks::isLoggedUser()){
				include "Model/model_defaultUserVerification.php";
				include "Model/Races/model_racesPage.php";
				$inBody = "View/Races/view_racesPage.php";
				include "View/view_default.php";
			}
			else {
				header_remove();
				header("Location: ?nav=405");
			}
			break;
	}

}
else if(isset($_GET["contestview"])){
	if(UserTasks::isLoggedUser()){
		if(is_numeric($_GET["contestview"])){
			$contest = DBLoad::loadContest($_GET["contestview"]);
			$result = $DBTasks->select(DBData::getMainUserTable(),DBData::$mainUserID,
					DBData::$fedLeaderFEDID."=".$contest->getOrgID()." OR ".DBData::$clubLeaderCLUBID."=".$contest->getOrgID(),
					"left join ".DBData::getFedLeaderTable()." ON ".
					DBData::getMainUserTable().".".DBData::$mainUserID."=".DBData::getFedLeaderTable().".".DBData::$fedLeaderMUID.
					" left join ".DBData::getClubLeaderTable()." ON ".
					DBData::getMainUserTable().".".DBData::$mainUserID."=".DBData::getClubLeaderTable().".".DBData::$clubLeaderMUID);
			$creator = (is_numeric($result[DBData::$mainUserID]) && $result[DBData::$mainUserID] == $_SESSION["User"]->getId());

			include 'Model/model_defaultUserVerification.php';

			if(isset($_GET["more"])){

				switch($_GET["more"]){
					case "entry":
						if($contest->getIsEntry() && !$contest->isDataChecks()&& UserTasks::isClubLeader()){
							include "Model/contestView/entry/model_entryPage.php";
							$inBody ="View/contestView/entry/view_entryPage.php";
						}
						else {
							include "Model/contestView/model_contestView.php";
							$inBody ="View/contestView/view_contestView.php";
						}

						break;
					case "datacheck":
						if(($contest->isDataChecks() && $creator) && !$contest->isClosed()){
							include "Model/contestView/checks/model_DataChecks.php";
							$inBody = "View/contestView/checks/view_DataChecks.php";
						}
						else {
							include "Model/contestView/model_contestView.php";
							$inBody ="View/contestView/view_contestView.php";
						}

						break;
					case "schedule":
						if(($contest->isDataChecks() && $creator) && !$contest->isClosed()){
							include "Model/contestView/schedule/model_CompSchedule.php";
							$inBody = "View/contestView/schedule/view_CompSchedule.php";
						}
						else {
							include "Model/contestView/model_contestView.php";
							$inBody ="View/contestView/view_contestView.php";
						}

						break;
					case "adminLogin":
						if(($contest->isDataChecks()) && !$contest->isClosed()){
							include "Model/contestView/adminLog/model_adminLog.php";
							$inBody = "View/contestView/adminLog/view_adminLog.php";
						}
						else {
							include "Model/contestView/model_contestView.php";
							$inBody ="View/contestView/view_contestView.php";
						}

						break;
					case "closed":
						if(($contest->isDataChecks() || $contest->isClosed())){
							include "Model/contestView/closed/model_closed.php";
							$inBody = "View/contestView/closed/view_closed.php";
						}
						else {
							include "Model/contestView/model_contestView.php";
							$inBody ="View/contestView/view_contestView.php";
						}

						break;
					default:
						include "Model/contestView/model_contestView.php";
						$inBody ="View/contestView/view_contestView.php";
				}
				unset($contest);
			}
			else {
				include "Model/contestView/model_contestView.php";
				$inBody ="View/contestView/view_contestView.php";
			}

			//include 'Model/model_profile.php';

			include 'View/view_default.php';
		}
		else {
			header_remove();
			header("Location: ?nav=404");
		}
	}
	else {
		header_remove();
		header("Location: ?nav=405");
	}

}
else if(isset($_GET["profile"])){
	include 'Model/model_defaultUserVerification.php';
	include 'Model/model_profile.php';
	include 'View/view_default.php';
}
else{
	include 'Model/model_defaultUserVerification.php';
	include "Model/model_home.php";
	$inBody = "View/view_home.php";
	include 'View/view_default.php';
}
function resetSESSIONs(){
	unset($_SESSION["regName"]);
	unset($_SESSION["regEmail"]);
	unset($_SESSION["regTel"]);
}
