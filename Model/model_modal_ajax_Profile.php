<?php
include "../includeClasses.php";
DBLoad::init();
$User = DBLoad::loadUser($_POST["id"]);
$ShowerUserID= $_POST["myUserID"];
$ugyanazUser= ($User->getId()==$ShowerUserID);
if($User!=null){
	echo "<div class='modal fade' id='profileModal'>";
		echo "<div class='modal-dialog'>";
			echo "<div class='modal-content'>";
			echo "<div class='modal-header'>";
				echo "Profil";
			echo "</div>";
			echo "<div class='modal-body'>";
				echo "<div class='row center-block text-center'>";
					echo "<div class='col-xs-6'>";
						echo "<strong>Név</strong>";
					echo "</div>";
					echo "<div class='col-xs-6'>";
						echo $User->getName();
					echo "</div>";
					echo "<div class='col-xs-6'>";
						echo "<strong>Email</strong>";
					echo "</div>";
					echo "<div class='col-xs-6'>";
						echo $User->getEmail();
					echo "</div>";
					echo "<div class='col-xs-6'>";
						echo "<strong>Telefon</strong>";
					echo "</div>";
					echo "<div class='col-xs-6'>";
						echo $User->getTelefon();
					echo "</div>";
				echo "</div>";
				if($ugyanazUser){
					echo "<div class='row center-block text-center'>";
					echo "aza user";
					echo "</div>";
				}

			echo "</div>";
			echo "<div class='modal-footer'>";
				echo "<button type=\"button\" class=\"btn btn-default\" id='modalProfileClose'>Close</button>";
			echo "</div>";
		echo "</div>";
	echo "</div>";
}
else {
	echo "<div class='modal fade' id='profileModal'>";
	echo "<div class='modal-dialog'>";
	echo "<div class='modal-content'>";
	echo "<div class='modal-header'>";
	echo "Profil";
	echo "</div>";
	echo "<div class='modal-body'>";
	echo "<div class=\"row center-block text-center\">
	<div class=\"col-xs-12 col-md-12 alert alert-warning\">
		<strong>Hiba!</strong> Nem létező felhasználó!
	</div>
</div>";
	echo "</div>";
	echo "<div class='modal-footer'>";
	echo "<button type=\"button\" class=\"btn btn-default\" id='modalProfileClose'>Close</button>";
	echo "</div>";
	echo "</div>";
	echo "</div>";

}