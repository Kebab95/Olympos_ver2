<script type="application/javascript">
	var myvar = <?php echo $valami; ?>;
	//console.log(myvar);
	function newCompType(num){
		$("#numberHidden").val(num);
		$("#typeModal").modal('show');
	}
</script>
<form method="post" id="raceForm2">
	<h3 class="text-center">Verseny szám Létrehozása / Beállítása <br> <small>Maximum 10 varsenyszám hozható létre</small></h3>
	<script src="Model/Races/fieldNameScript3.js"></script>
	<div class="input_fields_wrap">
	</div>
	<hr>
	<button class="btn btn-success center-block add_field_button">Új Verseny szám hozzáadása</button>
	<hr>


	<div class="form-group row text-center">
		<input type="submit" class="btn btn-success" value="Verseny számok elkészítése" name="createRace2" id="createRace2">
	</div>
	<input type="hidden" name="orgID" value="<?php echo $orgID;?>">
	<input type="hidden" name="contestID" value="<?php echo $contestID?>">
	<input type="hidden" id="compNumber" name="compNumber" value="1">
</form>
<div class="modal fade" id="typeModal" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				Új Típus hozzáadása
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-4"><input type="text" id="typeName" class="form-control"></div>
					<div class="col-md-4"><select class="form-control" id="typeEvent">
							<option value="0">Küzdelmi</option>
							<option value="1">Technikai</option>
						</select> </div>
					<div class="col-md-4">
						<input type="hidden" id="numberHidden">
						<button class="btn btn-success btn-block" type="button" id="addNewType">Hozzáadás</button> </div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger" data-dismiss="modal">Bezárás</button>
			</div>
		</div>
	</div>
</div>
<script>

$("#addNewType").click(function(){
	console.log("add");
	var typeName = $("#typeName").val();
	var typeNum = $("#typeEvent").val();
	var numberHidden = $("#numberHidden").val();
	console.log(typeName);
	if(typeName.length>0){
		$.ajax({
			url:'Model/contestView/model_ajax_addNewType.php',
			type: 'POST',
			data: {typeName:typeName,typeEventNum:typeNum,orgID: <?php echo $orgID?>},
			dataType:'HTML'
		}).done(function(data){
			console.log(data);
			var select = $("#compTypeSelectList"+numberHidden);
			select.html(data);
			alert("Hozzáadva");
			$("#typeModal").modal('toggle');
			$("#typeName").val("");
		}).fail(function(){
			alert("Hiba!");
		});
	}

});
</script>
