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
			if(UserTasks::isLoggedUser()){
				include "Model/model_defaultUserVerification.php";
				include "Model/myClub/model_myCubPage.php";

				$inBody = "View/myClub/view_myClubPage.php";
				include "View/view_default.php";
			}
			else{

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
			if(UserTasks::isLoggedUser() && (UserTasks::isClubLeader() || UserTasks::isFederationLeader())){
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
			include 'Model/model_defaultUserVerification.php';

			if(isset($_GET["more"]) && $_GET["more"]=="entry"){
				include "Model/contestView/entry/model_entryPage.php";
				$inBody ="View/contestView/entry/view_entryPage.php";
			}
			else if(isset($_GET["more"]) && $_GET["more"]=="datacheck"){
				include "Model/contestView/checks/model_DataChecks.php";
				$inBody = "View/contestView/checks/view_DataChecks.php";
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
