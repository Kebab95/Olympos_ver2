<div class="modal fade" id="newComp" role="dialog">
	<div class="modal-dialog">

			<div class="modal-header">

			</div>
			<div class="modal-body">
				<form method="post" action="" id="newCompForm">
					<div class="row form-group">
						<div class="col-xs-6">
							<label for="newComName">Versenyszám neve</label>
						</div>
						<div class="col-xs-6">
							<input type="text" class="form-control" id="newComName">
						</div>
					</div>
					<div class="row form-group">
						<div class="col-xs-6">
							<label>Verseyszám típusa</label>
						</div>
						<div class="col-xs-6">
							<select class="form-control" id="newCompType">
								<?php
								/** @var CompTypes $item */
								foreach ($compTypesArray as $item) {
									if($item->getEvents(DBData::getCompTypesFlag(0))){
									    $event ="Küzdelmi";
									}
									else if($item->getEvents(DBData::getCompTypesFlag(1))){
									    $event ="Technikai";
									}
									else {
										$event ="Nincs";
									}
									echo "<option value='".$item->getId()."'>".$item->getName()." (".$event.")</option>";
								}
								?>
							</select>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-12"><input type="button" value="Létrehoz" id="subNewComp" class="btn btn-default btn-block"></div>
					</div>
				</form>
				<script>
					$("#subNewComp").click(function(){
						$.ajax({
							url:'Model/contestView/model_ajax_newComp.php',
							type: 'POST',
							data: {compName: $("#newComName").val(),
								comTypeID: $("#newCompType").val(),
								orgID: <?php echo $compTypesArray[0]->getMuId()?>,
								contestID: <?php echo $data[DBData::$contestID]?>},
							dataType:'TEXT'
						}).done(function(data){
							if(data=="false"){

							}
							else {
								location.reload();
							}
						}).fail(function(){
							alert("Hiba!");
						});
					});
				</script>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>