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
}
else if(isset($_GET["nav"])){
	//resetSESSIONs();
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
			include 'Model/model_defaultUserVerification.php';
			include 'Model/model_fedPage.php';
			$inBody = "View/Organization/view_orgPage.php";
			include 'View/view_default.php';
			break;
		case 'club':
			include 'Model/model_defaultUserVerification.php';
			include 'Model/model_clubPage.php';
			$inBody = "View/Organization/view_orgPage.php";
			include 'View/view_default.php';
			break;
		case 'settings':
			if(isset($_SESSION["User"])){
				include "Model/model_defaultUserVerification.php";
				include "Model/model_settings.php";

				$inBody = "View/Settings/view_settings.php";
				include "View/view_default.php";
				unset($_SESSION["collapsOpenProfile"]);
			}
			else {
				header_remove();
				header("Location: ?nav=home");
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
			include "View/view_default.php";
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