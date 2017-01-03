<?php
session_start();
/*
$json =$_SESSION["testJSON"];
echo json_decode($json)->orgPTown;
*/

//Divizoók
//Kategoria

//Nem beállítás egymás elln vagy külön
//Csapat verseny (Divitió)

//Korhatár
?>
<form method="post" id="raceForm2">
	<h3 class="text-center">Verseny szám Létrehozása / Beállítása <br> <small>Maximum 10 kategória hozható létre</small></h3>
	<script src="Model/Races/fieldNameScript.js"></script>
	<div class="input_fields_wrap">
	</div>
	<hr>
	<button class="btn btn-success center-block add_field_button">Új Verseny szám hozzáadása</button>
	<hr>


	<div class="form-group row text-center">
		<input type="submit" class="btn btn-success" value="Tovább" name="createRace2" id="createRace2">
	</div>
	<input type="hidden" id="createRaceHidden" name="createRaceHidden" value="">
</form>
