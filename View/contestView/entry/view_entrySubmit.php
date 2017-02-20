<?php
if($error){
	echo "<label>nem választott ki semmilyen versenyzőt!</label>";
}
else {
	?>
		<div class="row">
			<div class="col-md-2"></div>
			<div class="col-md-8">
				<div class="panel panel-success">
					<div class="panel-heading text-center">
						<h3>Nevezés véglegesítése</h3>
					</div>
					<div class="panel-body">
						<div class="row">

							<div class="col-md-2"></div>
							<div class="col-md-4">Versenyző neve</div>
							<div class="col-md-4">Nevezésre kívánt verseny szám</div>
							<div class="col-md-2" ></div>

						</div>
						<form action="" method="post" id="entrySubmitForm">

							<?php
							foreach ($memberArray as $item) {
								$option ="";
								foreach ($compArray as $value) {
									$option.="<option value='".$value[DBData::$competetionsID]."'>".$value[DBData::$competetionsTitle]."</option>";
								}
								echo '<hr><div class="row" style="padding-top:20px;"> <div class="col-md-3"></div>
							<div class="col-md-3">'.$item[DBData::$mainUserName].'
							<input type="hidden" name="memberID[]" value="'.$item[DBData::$mainUserID].'"></div>
							<div class="col-md-3">
								<select multiple class="form-control" name="selectComp'.$item[DBData::$mainUserID].'[]">
									'.$option.'
								</select>
							</div>
							<div class="col-md-3"></div></div>
							';
							}
							?>
							<hr>
							<div class="row">
								<div class="col-md-12">
									<input type="hidden" name="clubID" value="<?php echo $_POST["clubID"]?>">
									<input type="hidden" name="contestID" value="<?php echo $_GET["contestview"]?>">
									<input type="submit" class="btn btn-success btn-block" value="Nevezés véglegesítése">
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-2"></div>
		</div>

	<script>
		$("#entrySubmitForm").submit(function(e){
			e.preventDefault();
			$.ajax({
				url:'Model/contestView/entry/model_ajax_entrySubmit.php',
				type: 'POST',
				data: $(this).serialize(),
				dataType:'text'
			}).done(function(data){
				if(data=="false"){

				}
				else {
					alert("Sikeres nevezés, kérjük az esemény időpontján jelenjen meg. Sok sikert kívánunk!");
					window.location.href = "?nav=home";
				}

			}).fail(function(){
				alert("Hiba!");
			});
		});
	</script>
	<?php
}