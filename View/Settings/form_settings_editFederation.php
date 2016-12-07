<?php
if($fedLeader){

}
else {
?>
<div class="regInputs center-block text-center">
	<h3>Nincs Szövetséghez kapcsolva</h3>
	Létrehozhat egy újjat vagy csatlakozat is egyhez<br>

	<input type="submit" class="btn btn-default" name="createFed"value="Új létrehozása" >
	<br><br>Csatlakozás meglévőhöz<br>
	<?php echo($clubleader?"":"<strong>Csak az egyesület vezetők csatlakozhatnak Szövetséghez</strong>")?>
	<input type="submit" class="btn <?php echo($clubleader?"btn-success":"btn-danger")?>" <?php echo($clubleader?"":"disabled")?> value="Keresés">

</div>
<?php
}
?>