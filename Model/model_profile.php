<?php

if(is_numeric($_GET["profile"])){
	$profUser = DBLoad::loadUser($_GET["profile"]);
	if($profUser!=null){

		/** @var User $profUser */
		//$profUser = DBLoad::loadUser($_GET["profile"]);
		$profName = $profUser->getName();
		$profTel = $profUser->getTelefon();


		if(UserTasks::isLoggedUser()){
			/** @var User $obj */
			$obj = $_SESSION["User"];
			$profEmail = $profUser->getEmail();

			if($profUser->getId() == $obj->getId()){

				$profEdit =true;
				$profID = $profUser->getId();
			}
			else {
				$profEdit =false;
			}
		}
		else {
			$justRegUsers ="<div class=\"col-xs-12 col-md-12 alert alert-warning\">
					Csak belépett tagoknak!
			</div>";

			$profEdit ="";
			$profEmail = $justRegUsers;
			$profTel = $justRegUsers;
		}


		$inBody="View/Profile/view_profile.php";
	}
	else{
		$inBody= "View/Profile/view_dontActiveProfile.php";
	}
}
else {
	$inBody= "View/Profile/view_dontActiveProfile.php";
}
