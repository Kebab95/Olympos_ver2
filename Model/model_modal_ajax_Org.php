<?php
include "../includeClasses.php";
DBLoad::init();
$Org = DBLoad::loadOrg($_POST["id"]);
$ShowerUserID= $_POST["myUserID"];
$ugyanazUser = ($Org->getLeaderID() == $ShowerUserID);
if($Org!=null){
	?>
	<div class='modal fade' id='profileModal'>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					Szövetségi profil
				</div>
				<div class="modal-body">
					<div class="row form-group">
						<div class="col-md-2"></div>
						<div class="col-md-8">
							<div class="row">
								<div class="col-xs-6 text-right">Név</div>
								<div class="col-xs-6"><?php echo $Org->getName()?></div>
							</div>
							<div class="row">
								<div class="col-xs-6 text-right">Vezető neve</div>
								<div class="col-xs-6"><?php echo DBLoad::loadUserWithoutActive($Org->getLeaderID())->getName()?></div>
							</div>
							<div class="row">
								<div class="col-xs-6 text-right">Email</div>
								<div class="col-xs-6"><?php echo $Org->getEmail()?></div>
							</div>
							<div class="row">
								<div class="col-xs-6 text-right">Telefon</div>
								<div class="col-xs-6"><?php echo $Org->getTelefon()?></div>
							</div>
							<div class="row">
								<div class="col-xs-6 text-right">Weboldal</div>
								<div class="col-xs-6"><?php echo $Org->getWebSite()==""?"Nincs weboldala":$Org->getWebSite()?></div>
							</div>
						</div>
						<div class="col-md-2"></div>
					</div>
					<?php
					if($ugyanazUser){
						?>
						<div class="row form-group">
							<div class="col-md-4"></div>
							<div class="col-md-4">
								<a href='?nav=settings&open=<?php echo $Org->getType()==2?"fed":"club"?>'> <button class="btn btn-info2 btn-block">Szerkesztés</button></a>
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
		<strong>Hiba!</strong> Nem létező szervezet!
	</div>
</div>";
	echo "</div>";
	echo "<div class='modal-footer'>";
	echo "<button type=\"button\" class=\"btn btn-default\" id='modalProfileClose'>Close</button>";
	echo "</div>";
	echo "</div>";
	echo "</div>";
}