<?php
if($clubleader){

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
			<input type="submit" class="btn btn-info" value="Keresés">

		</div>
		<?php
	}
}