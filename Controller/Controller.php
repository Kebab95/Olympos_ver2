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

}
else if(isset($_GET["nav"])){
	resetSESSIONs();
	switch($_GET["nav"]){
		case 'home':
			include 'Model/model_defaultUserVerification.php';
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

			if(Tasks::isLoggedUser()){
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

			if(Tasks::isLoggedUser()){
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

			if(Tasks::isLoggedUser()){
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
			if(Tasks::isLoggedUser()){
				include "Model/model_defaultUserVerification.php";
				include "Model/myClub/model_myCubPage.php";

				$inBody = "View/myClub/view_myClubPage.php";
				include "View/view_default.php";
			}
			else{

			}
			break;
		case 'races':
			if(Tasks::isLoggedUser()){
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
elseif(isset($_GET["race"])){
	switch($_GET["race"]){
		case "create":
			if(Tasks::isLoggedUser()){
				include "Model/model_defaultUserVerification.php";
				include "Model/Races/model_raceCreate.php";
				//include "Model/Races/model_racesPage.php";
				$inBody = "View/Races/view_raceCreate.php";
				include "View/view_default.php";
			}
			else {
				header_remove();
				header("Location: ?nav=405");
			}
			break;
		case "list":
			if(Tasks::isLoggedUser()){
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
else if(isset($_GET["profile"])){
	include 'Model/model_defaultUserVerification.php';
	include 'Model/model_profile.php';
	include 'View/view_default.php';
}
else{
	include 'Model/model_defaultUserVerification.php';
	$inBody = "View/view_home.php";
	include 'View/view_default.php';
}
function resetSESSIONs(){
	unset($_SESSION["regName"]);
	unset($_SESSION["regEmail"]);
	unset($_SESSION["regTel"]);
}
