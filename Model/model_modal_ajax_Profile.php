<?php
include "../includeClasses.php";
DBLoad::init();
$User = DBLoad::loadUserWithoutActive($_POST["id"]);
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
					<div class="row form-group">
						<div class="col-md-3"></div>
						<div class="col-md-6">
							<div class="row">
								<div class="col-xs-6 text-right">Név</div>
								<div class="col-xs-6"><?php echo $User->getName()?></div>
							</div>
							<div class="row">
								<div class="col-xs-6 text-right">Neme</div>
								<div class="col-xs-6"><?php echo $User->getSex()?></div>
							</div>
							<div class="row">
								<div class="col-xs-6 text-right">Email</div>
								<div class="col-xs-6"><?php echo $User->getEmail()?></div>
							</div>
							<div class="row">
								<div class="col-xs-6 text-right">Telefon</div>
								<div class="col-xs-6"><?php echo $User->getTelefon()?></div>
							</div>
						</div>
						<div class="col-md-3"></div>
					</div>
					<?php
					if($ugyanazUser){
						?>
						<div class="row form-group">
							<div class="col-md-4"></div>
							<div class="col-md-4">
								<a href="?nav=settings&open=profile"> <button class="btn btn-info2 btn-block">Szerkesztés</button></a>
							</div>
							<div class="col-md-4"></div>
						</div>
						<?php
					}
					?>



				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-4"></div>
						<div class="col-md-4">
							<button type="button" class="btn btn-danger btn-block" id='modalProfileClose'>Close</button>
						</div>
						<div class="col-md-4"></div>
					</div>

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