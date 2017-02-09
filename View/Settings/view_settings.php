	<form method="post" action="">
	<h2>Beállítások</h2>
	<div class="panel-group" id="accordion">
		<div class="panel panel-info">
			<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Felhasználói adatok</a>
				</h4>
			</div>
			<div id="collapse1" class="panel-collapse collapse <?php echo (empty($_SESSION["collapsOpenProfile"])?"":"in")?>">
				<div class="panel-body">
					<?php include "View/Settings/form_settings_EditProfile.php";?>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse2">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Egyesületi adatok</a>
				</h4>
			</div>
			<div id="collapse2" class="panel-collapse collapse">
				<div class="panel-body">
					<?php
						include "View/Settings/form_settings_EditClub.php";
					?>
				</div>
			</div>
		</div>
		<div class="panel panel-default" >
			<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse3">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Szövetségi adatok</a>
				</h4>
			</div>
			<div id="collapse3" class="panel-collapse collapse">
				<div class="panel-body">
					<?php
						include "View/Settings/form_settings_EditFederation.php";
					?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class=" regInputs center-block text-center">
	<div class="row">
		<div class="col-md-12">
			<h4>Változtatások jóváhagyása</h4>
		</div>
		<div class="col-md-6">
			Jelszó
		</div>
		<div class="col-md-6">
			<input type="password" class="form-control">
		</div>
		<div class="col-md-12">
			<input type="submit" value="Jóváhagyás" class="btn btn-success">
		</div>

	</div>
	</form>