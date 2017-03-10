<div class="modal fade" id="newComp" role="dialog">
	<div class="modal-dialog">
	<div class="modal-content">
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
						<div class="col-md-6">&nbsp;</div>
						<div class="col-md-6">
							<button class="btn btn-info2 btn-block" type="button" data-toggle="collapse" data-target="#newType">Új típus hozzáadása</button>

						</div>
						<div class="col-md-12">

							<div id="newType" class="collapse">
								<hr>
								<div class="row">
									<div class="col-md-4"><input type="text" id="typeName" class="form-control"></div>
									<div class="col-md-4"><select class="form-control" id="typeEvent">
											<option value="0">Küzdelmi</option>
											<option value="1">Technikai</option>
										</select> </div>
									<div class="col-md-4"><button class="btn btn-success btn-block" type="button" id="addNewType">Hozzáadás</button> </div>
								</div>
							</div>
						</div>
					</div>
					<div class="row form-group">
						<div class="col-md-12"><input type="button" value="Létrehoz" id="subNewComp" class="btn btn-success btn-block"></div>
					</div>
				</form>
				<script>
					$("#subNewComp").click(function(){
						var ComName = $("#newComName").val();
						var ComTypeID = $("#newCompType").val();
						if(ComName.length>0 && ComTypeID>0){
							$.ajax({
								url:'Model/contestView/model_ajax_newComp.php',
								type: 'POST',
								data: {compName: ComName,
									comTypeID: ComTypeID,
									orgID: <?php echo $contest->getOrgID()?>,
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
						}
						else{
							alert("Nem írt az összes mezőbe!");
						}

					});
					$("#addNewType").click(function(){
						var typeName = $("#typeName").val();
						var typeNum = $("#typeEvent").val();
						console.log(typeName);
						if(typeName.length>0){
							$.ajax({
								url:'Model/contestView/model_ajax_addNewType.php',
								type: 'POST',
								data: {typeName:typeName,typeEventNum:typeNum,orgID: <?php echo $contest->getOrgID()?>},
								dataType:'HTML'
							}).done(function(data){
								console.log(data);
								var select = $("#newCompType");
								select.html(data);
								alert("Hozzáadva");
							}).fail(function(){
								alert("Hiba!");
							});
						}

					});
				</script>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
	</div>
</div>