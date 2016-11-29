<?php

if(is_numeric($_GET["profile"])){
	if($DBTasks->isActiveUser($_GET["profile"])){
		/** @var User $profUser */
		$profUser = $DBTasks->loadUser($_GET["profile"]);
		$profName = $profUser->getName();
		if(isset($_SESSION["User"])){
			/** @var User $obj */
			$obj = $_SESSION["User"];
			$profEmail = $profUser->getEmail();
			if($profUser->getId() == $obj->getId()){
				$profEdit ="<form method='post' action=''>
							<div class='col-md-12 col-xs-12'>
								<input type='submit' value='Profil szerkesztése' class='btn btn-info'/>
								<input type='hidden' value='".$profUser->getId()."' name='editProfHidden'/>
							</div>
							</form>";
			}
			else {
				$profEdit ="";
			}
		}
		else {
			$justRegUsers ="<div class=\"col-xs-12 col-md-12 alert alert-warning\">
					Csak belépett tagoknak!
			</div>";
			$profEdit ="";
			$profEmail = $justRegUsers;
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
