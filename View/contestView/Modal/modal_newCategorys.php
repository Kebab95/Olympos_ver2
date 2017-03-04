<?php /** @var Competetion $item */ ?>
<div class="modal fade" id="myModal<?php echo $item->getId()?>" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">

			</div>
			<div class="modal-body">
				<ul class="nav nav-tabs">
					<li class="nav active"><a href="#A" data-toggle="tab">Létrehozás</a></li>
					<li class="nav"><a href="#B" data-toggle="tab">Keresés</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane fade in active" id="A">

						<hr>
						<div class="row">
							<div class="col-xs-2"></div>
							<div class="col-xs-8">
								<label class="text-justify">Jobb klikkel
									hosszan nyomva többet ki választhat vagy,egyenként
									CTRL billentyűvel egyenként ki választhat sorokat<br>
									(Mobilon felugrik egy ablak)</label>
							</div>
							<div class="col-xs-2"></div>
						</div>
						<form method="post" id="newCatForm<?php echo $item->getId()?>" onsubmit="">
							<div class="row form-group">
								<div class="col-xs-2 col-md-2">Életkor</div>
								<div class="col-xs-9 col-md-6">
									<select multiple class="form-control" size="10" id="ageGrpSelect<?php echo $item->getId()?>" name="ageGrpSelect<?php echo $item->getId()?>">

										<?php
										if(count($ageGrp[$item->getId()])>0){
											foreach ($ageGrp[$item->getId()] as $age) {
												echo "<option value='".$age[DBData::$ageGrpID]."'>".$age[DBData::$ageGrpMin]."-".$age[DBData::$ageGrpMax]."</option>";
											}
										}
										else {
											echo '<option>"Nincsen csoport hozzáadva"</option>';
										}

										?>
									</select>
								</div>
								<div class="col-xs-1 col-md-4">
									<input class="btn btn-info btn-block" onclick="buttonChange(this,'Új életkor')" type="button" value="Új életkor" data-toggle="collapse" data-target="#ageGrpCollapse<?php echo $item->getId()?>">
								</div>


							</div>
							<div class="row">
								<div class="col-xs-2 col-md-2"></div>
								<div class="col-xs-8 col-md-8">
									<div id="ageGrpCollapse<?php echo $item->getId()?>" class="collapse">
										<hr>
										<div class="row">
											<div class="col-xs-12">Új Életkor</div>
											<div class="col-xs-5"><input type="number" min="0" max="100" name="newageGrpMin<?php echo $item->getId()?>" class="form-control" id="newageGrpMin<?php echo $item->getId()?>"></div>
											<div class="col-xs-2">-</div>
											<div class="col-xs-5"><input type="number" min="1" max="100" name="newageGrpMax<?php echo $item->getId()?>" class="form-control" id="newageGrpMax<?php echo $item->getId()?>"></div>
										</div>
										<div class="row">
											<div class="col-xs-12">

												<input type="button" class="btn btn-default btn-block" onclick="newAge(<?php echo $item->getId()?>)" value="Létrehozás" id="newageGrpButton<?php echo $item->getId()?>">
											</div>
										</div>
										<script>
											function newAge(number){
												var minNum ="#newageGrpMin"+number;
												var maxNum ="#newageGrpMax"+number;
												var orgid ="#CompOrgId"+number;
												var typeid ="#CompTypeId"+number;
												var compid ="#CompId"+number;
												/*
												$("#ageGrpSelect"+number+" option").each(function()
												{
													console.log($(this).text());
												});
												*/

												$.ajax({
													url: 'Model/contestView/model_ajax_newAgeGrp.php',
													type: 'POST',
													data: {min:$(minNum).val(),
														max:$(maxNum).val(),
														org_id:$(orgid).val(),
														type_id:$(typeid).val(),
														comp_id:$(compid).val()},
													dataType: "JSON"
												}).done(function(data){

													console.log(data);

													var select ="#ageGrpSelect"+number;
													$(select)
															.find('option')
															.remove()
															.end()
													;
													//console.log(data[number]);
													$.each(data[number], function(i, value) {
														$(select).append($('<option>').text(value.<?php echo DBData::$ageGrpMin ?>+"-"+value.<?php echo DBData::$ageGrpMax ?>).attr('value', value.<?php echo DBData::$ageGrpID?>));
													});
													$("#ageGrpCollapse"+number).removeClass("in");

													alert("Új életkor hozzáadva!");



												}).fail(function(ts){
													console.log(ts.responseText);
													alert("Hiba az ajax-al");
												});
											}
										</script>
										<hr>
									</div>
								</div>
								<div class="col-xs-2 col-md-2"></div>
							</div>
							<div class="row form-group">
								<div class="col-xs-2 col-md-2">Csoport</div>
								<div class="col-xs-6 col-md-6">
									<?php
									if($item->getType()->getEvents(DBData::getCompTypesFlag(0))){
										?>
										<select multiple class="form-control" size="10" id="personalGrpSelect<?php echo $item->getId()?>" name="personalGrpSelect<?php echo $item->getId()?>">

											<?php
											if(count($compPerson[$compid])>0){
												foreach ($compPerson[$compid] as $compPers) {
													echo "<option value='".$compPers[DBData::$personalGrpID]."'>".$compPers[DBData::$personalGrpTitle]."</option>";
												}
											}
											else {
												echo '<option>"Nincsen csoport hozzáadva"</option>';
											}

											?>
										</select>
										<?php
									}
									else{
										$chechBoxID = array();
										foreach ($beltKnowLedge as $knowledge) {
											echo "<input type='checkbox' id='checkBox".$knowledge[DBData::$knowLedgeId].$item->getId()."' value='".$knowledge[DBData::$knowLedgeId]."'> ";
											echo "<label for='checkBox".$knowledge[DBData::$knowLedgeId].$item->getId()."'>".$knowledge[DBData::$knowLedgeName]."</label><br>";
											array_push($chechBoxID,"checkBox".$knowledge[DBData::$knowLedgeId].$item->getId());
										}
									}
									?>


								</div>
								<div class="col-xs-4 col-md-4">
									<?php
									if($item->getType()->getEvents(DBData::getCompTypesFlag(0))){
									    ?>
										<input class="btn btn-info btn-block" onclick="buttonChange(this,'Új csoport');" type="button" value="Új csoport" data-toggle="collapse" data-target="#personalCollapse<?php echo $item->getId()?>">
										<?php
									}
									else{
										?>
											<input type="hidden" id="checkBoxID" value='<?php echo json_encode($chechBoxID)?>'>
										<?php
									}
									?>


								</div>

							</div>
							<div class="row">
								<div class="col-xs-1"></div>
								<div class="col-xs-10">
									<div id="personalCollapse<?php echo $item->getId()?>" class="collapse">
										<hr>
										<div class="row">

											<?php
											$PersonalType = 0;
											if($item->getType()->getEvents(DBData::getCompTypesFlag(0))){
												$PersonalType= 0;
											    ?>
												<div class="col-xs-4"><label>Súly csoport (minimum,maximum) [Kg]</label><br><label>(Küzdelmi szám)</label></div>
													<div class="col-xs-8">
														<div class="row">
															<div class="col-xs-6"><input type="number" class="form-control" id="personalNumMin<?php echo $item->getId()?>"></div>
															<div class="col-xs-6"><input type="number" class="form-control" id="personalNumMax<?php echo $item->getId()?>"></div>
														</div>
													</div>
												<?php
											}
											else {
												$PersonalType=1;
												?>
												<div class="col-xs-4"><label>Tudás szint</label></div>
												<div class="col-xs-8"><input type="text" class="form-control" name="newPersonalGrpTitle<?php echo $item->getId()?>" id="newPersonalGrpTitle<?php echo $item->getId()?>"></div>
												<?php
											}
											?>

										</div>
										<div class="row">
											<div class="col-xs-12">
												<input type="hidden" value="<?php echo $PersonalType?>" id="personalType<?php echo $item->getId()?>">
												<input type="button" class="btn btn-default btn-block" onclick="newPersonal(<?php echo $item->getId()?>)" value="Létrehozás" id="newPersonalGrpButton<?php echo $item->getId()?>">
											</div>
										</div>
										<script type="text/javascript">

											function buttonChange(button,defaultTitle){
												if ($(button).hasClass('btn-info')){
													$(button).removeClass("btn-info");
													$(button).addClass("btn-danger");
													$(button).val("Bezár");
												}
												else {
													$(button).removeClass("btn-danger");
													$(button).addClass("btn-info");
													$(button).val(defaultTitle);
												}


											}
											function newPersonal(number){
												var orgid ="#CompOrgId"+number;
												var typeid ="#CompTypeId"+number;
												var compid ="#CompId"+number;
												var personalType = "#personalType"+number;
												var personalNum = new Array("");
												if($(personalType).val()==0){
													personalNum[0] = $("#personalNumMin"+number).val();
													personalNum[1] = $("#personalNumMax"+number).val();
												}
												else {
													personalNum[0]=$("#personalNum"+number).val();
													personalNum[1]=$("#personalNum"+number+" option:selected").text();

												}
												$.ajax({
													url: 'Model/contestView/model_ajax_newPersonalGrp.php',
													type: 'POST',
													data: {personalType: $(personalType).val(),
														personalNum:personalNum,
														org_id:$(orgid).val(),
														type_id:$(typeid).val(),
														comp_id:$(compid).val()},
													dataType: "JSON"
												}).done(function(data){
													console.log(data);

													var select ="#personalGrpSelect"+number;
													$(select)
															.find('option')
															.remove()
															.end()
													;
													$.each(data[number], function(i, value) {
														$(select).append($('<option>').text(value.<?php echo DBData::$personalGrpTitle ?>).attr('value', value.<?php echo DBData::$personalGrpID?>));
													});
													$("#personalCollapse"+number).removeClass("in");
													alert("Új csoport hozzáadva!");


												}).fail(function(e){
													console.log(e);
													alert("Hiba az ajax-al");
												});
											}
										</script>
										<hr>
									</div>
								</div>
								<div class="col-xs-1"></div>
							</div>
							<hr>
							<div class="row form-group">
								<div class="col-xs-3">Milyen kategóriák legyenek?</div>
								<div class="col-xs-3">
									<input type="checkbox" checked name="sex<?php echo $item->getId()?>" id="sex1<?php echo $item->getId()?>" value="0"> <label for="sex1<?php echo $item->getId()?>">Női</label><br>
									<input type="checkbox" checked name="sex<?php echo $item->getId()?>" id="sex0<?php echo $item->getId()?>" value="1"> <label for="sex0<?php echo $item->getId()?>">Férfi</label><br>
									<input type="checkbox" checked name="sex<?php echo $item->getId()?>" id="sex2<?php echo $item->getId()?>" value="2"> <label for="sex2<?php echo $item->getId()?>">Vegyes</label>
								</div>
								<div class="col-xs-4">
									<input type="checkbox" name="sex<?php echo $item->getId()?>" id="groupCat<?php echo $item->getId()?>" value="3"> <label for="groupCat<?php echo $item->getId()?>">Csoportos küzdelem</label>
								</div>
								<div class="col-xs-1"></div>
							</div>
							<div class="row form-group">
								<div class="col-xs-2 col-md-2">
									Egyéb árazások
								</div>
								<div class="col-xs-8 col-md-8">
									<div class="col-xs-12"><label class="text-justify">Egyéb árazás a kateógóriákra.
											Ha az értéke 0 akkor a verseny alap nevezési díja lesz az adott típusra</label>
									</div>
									<div class="col-xs-6">Szövetségi:</div>
									<div class="col-xs-6">Cost1: <input type="number" id="fedcost1<?php echo $item->getId()?>" value="0" min="0" class="form-control"></div>
									<div class="col-xs-6"></div>
									<div class="col-xs-6">Cost2: <input type="number" id="fedcost2<?php echo $item->getId()?>" value="0" min="0" class="form-control"></div>
									<hr>
									<div class="col-xs-6">Nem Szövetségi:</div>
									<div class="col-xs-6">Cost1: <input type="number" id="nonfedcost1<?php echo $item->getId()?>" value="0" min="0" class="form-control"></div>
									<div class="col-xs-6"></div>
									<div class="col-xs-6">Cost2: <input type="number" id="nonfedcost2<?php echo $item->getId()?>" value="0" min="0" class="form-control"></div>
									<hr>
									<div class="col-xs-6">Külföldi:</div>
									<div class="col-xs-6">Cost1: <input type="number" id="foreigncost1<?php echo $item->getId()?>" value="0" min="0" class="form-control"></div>
									<div class="col-xs-6"></div>
									<div class="col-xs-6">Cost2: <input type="number" id="foreigncost2<?php echo $item->getId()?>" value="0" min="0" class="form-control"></div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-xs-1 col-md-4"></div>
								<div class="col-xs-10 col-md-4">
									<input class="btn btn-block btn-success" type="submit" name="newCatSubmit<?php echo $item->getId()?>" id="newCatSubmit<?php echo $item->getId()?>" value="Létrehozás">
								</div>
								<div class="col-xs-1 col-md-4"></div>
							</div>
							<input type="hidden" value="<?php echo $item->getMuId()?>" name="CompOrgId<?php echo $item->getId()?>" id="CompOrgId<?php echo $item->getId()?>">
							<input type="hidden" value="<?php echo $item->getType()->getId()?>" name="CompTypeId<?php echo $item->getId()?>" id="CompTypeId<?php echo $item->getId()?>">
							<input type="hidden" value="<?php echo $item->getId()?>" name="CompId<?php echo $item->getId()?>" id="CompId<?php echo $item->getId()?>">
						</form>
					</div>


					<div class="tab-pane fade in active" id="B"></div>
				</div>
			</div>
			<script>
			$("form#newCatForm"+<?php echo $item->getId()?> +"").on("submit",function(e){
				//e.stopImmediatePropagation();
				e.preventDefault();
				var personalType = "#personalType<?php echo $item->getId()?>";
				var personalArray = new Array();
				if($(personalType).val()==0){
					personalArray =$("#personalGrpSelect<?php echo $item->getId()?>").val();
				}
				else {
					var temp = JSON.parse($("#checkBoxID").val());
					temp.forEach(function(data){
						var check = $("#"+data).val();
						if($("#"+data).is(':checked')){
							personalArray.push(check);
						}
						//console.log(check);

						//personalArray.add();
					});
					//personalArray =$("#checkBox<?php echo $item->getId()?>").val();

				}
				console.log(personalArray);
				$.ajax({
					url: 'Model/contestView/model_ajax_newCatInsert.php',
					type: 'POST',
					data: {ageSelect: $("#ageGrpSelect<?php echo $item->getId()?>").val(),
							groupSelect:personalArray,
							personalType:$(personalType).val(),
							sex0: $("#sex0<?php echo $item->getId()?>").is(':checked'),
							sex1: $("#sex1<?php echo $item->getId()?>").is(':checked'),
							sex2: $("#sex2<?php echo $item->getId()?>").is(':checked'),
							groupFight: $("#groupCat<?php echo $item->getId()?>").is(':checked'),
							fedcost1: $("#fedcost1<?php echo $item->getId()?>").val(),
							fedcost2: $("#fedcost2<?php echo $item->getId()?>").val(),
							nonfedcost1: $("#nonfedcost1<?php echo $item->getId()?>").val(),
							nonfedcost2: $("#nonfedcost2<?php echo $item->getId()?>").val(),
							foreigncost1: $("#foreigncost1<?php echo $item->getId()?>").val(),
							foreigncost2: $("#foreigncost2<?php echo $item->getId()?>").val(),
							org_id: $("#CompOrgId<?php echo $item->getId()?>").val(),
							comp_id:<?php echo $item->getId();?>,
							contest_id: <?php echo $_GET["contestview"]?>,
							comp_type: <?php echo $item->getType()->getId()?>},
					dataType: "TEXT"
				}).done(function(data){
					if(data=="false"){
						alert("Nem töltött ki minden mezőt! Vagy hiba esett a létrehozásban.")
					}
					else {

						console.log(data);
						location.reload();
					}
				}).fail(function(){
					alert("Hiba az ajax-al");
				});
				//return false;
			});
			</script>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>