<?php
include "../includeClasses.php";
DBLoad::init();
$User = DBLoad::loadUser($_POST["id"]);
$ShowerUserID= $_POST["myUserID"];
$ugyanazUser= ($User->getId()==$ShowerUserID);
if($User!=null){
	?>
	<div class='modal fade' id='profileModal'>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Profil
				</div>
				<div class="modal-body">
					<div class="row center-block text-center">
						<div class="col-xs-6">Név</div>
						<div class="col-xs-6"><?php echo $User->getName()?></div>
						<div class="col-xs-6">Neme</div>
						<div class="col-xs-6"><?php echo $User->getSex()?></div>
						<div class="col-xs-6">Email</div>
						<div class="col-xs-6"><?php echo $User->getEmail()?></div>
						<div class="col-xs-6">Telefon</div>
						<div class="col-xs-6"><?php echo $User->getTelefon()?></div>
					</div>
					<?php
					if($ugyanazUser){
						echo "<div class='row center-block text-center'>";
						echo "aza user";
						echo "</div>";
					}
					?>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-default" id='modalProfileClose'>Close</button>
				</div>
			</div>
		</div>
	</div>
<?php
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