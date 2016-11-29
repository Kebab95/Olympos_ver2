<?php
if($_POST){
	if(isset($_POST["login"])){
		include 'Model/model_userVerification.php';
		$inBody = "View/Login/view_login.php";
		include 'View/view_default.php';
	}
	else if(isset($_POST["editProfHidden"])){
		include "Model/model_userVerification.php";
		include "Model/model_editProf.php";
		$inBody = "View/Profile/view_editProfile.php";
		include "View/view_default.php";
	}
}
else if(isset($_GET["nav"])){
	switch($_GET["nav"]){
		case 'home':
			include 'Model/model_userVerification.php';
			$inBody = "View/view_home.php";
			include 'View/view_default.php';
			break;
		case 'reg':
			include 'Model/model_userVerification.php';
			$inBody = "View/view_reg.php";
			include 'View/view_default.php';
			break;
		case 'passhelp':
			include 'Model/model_userVerification.php';
			$inBody = "View/view_forgetPass.php";
			include 'View/view_default.php';
			break;
		case 'logout':
			header_remove();
			header("Location: ?nav=home");
			unset($_SESSION["User"]);
			break;
	}
}
else if(isset($_GET["profile"])){
	include 'Model/model_userVerification.php';
	include 'Model/model_profile.php';
	include 'View/view_default.php';
}
else{
	include 'Model/model_userVerification.php';
	$inBody = "View/view_home.php";
	include 'View/view_default.php';
}