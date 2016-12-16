<?php
if($clubleader){
	?>
		<div class="regInputs center-block text-center">
			<div class="col-md-6 col-xs-6">
				<strong>Egyesület Név</strong>
			</div>
			<div class="col-md-6 col-xs-6">
				<input type="text" class="form-control" value="<?php echo $clubName?>">
			</div>
		</div>
	<?php
}
else{
	if($clubMember){

	}
	else {
		?>
		<div class="regInputs center-block text-center">
			<h3>Nincs Egyesülethez kapcsolva</h3>
			Létrehozhat egy újjat vagy csatlakozat is egyhez<br>

			<input type="submit" class="btn btn-default" name="createClub" value="Új létrehozása">
			<br><br>Csatlakozás meglévőhöz<br>
			<a href="?nav=club"><input type="button" class="btn btn-info" value="Keresés"></a>

		</div>
		<?php
	}
}