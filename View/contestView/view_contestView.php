<div class="panel panel-default">
	<div class="panel-heading text-center">
		<h4><?php echo $data[DBData::$contestName];?></h4>
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-3">
				<?php
					if($creator){
					    echo "<div class='text-center'>
							<button class='btn btn-default btn-block'>Szerkesztés</button>
							</div>";
					}
				?>
			</div>

			<div class="col-md-6">
				<div class="panel-group" id="accordion">
					<div class="panel panel-default">
						<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse2">
							Alap adatok
						</div>
						<div id="collapse2" class="panel-collapse collapse in">
							<div class="panel-body">
								<div class="row">
									<label class="col-xs-6 "><strong>Szervező szervezet</strong></label>
									<label class="col-xs-6 "><?php echo $data[DBData::$contestOrgID]?></label>
									<label class="col-xs-6 span6"><strong>Helyszín</strong></label>
									<label class="col-xs-6 "><?php echo $data[DBData::$contestLocaleID]?></label>
									<label class="col-xs-6">Dátum</label>
									<label class="col-xs-6"><?php echo $data[DBData::$contestDate]?></label>
									<label class="col-xs-6">Alap nevezési díj</label>
									<label class="col-xs-6"><?php echo $data[DBData::$contestEntryFee]?></label>
									<label class="col-xs-6">Leírás</label>
									<label class="col-xs-6"><?php echo $data[DBData::$contestDesc]?></label>
									<input type='hidden' name='contestID' id="contestID" value="<?php echo $data[DBData::$contestID]?>">
									<?php
									if($creator){
										if($data[DBData::$contestDataChecks]){
											echo "<div class='col-xs-6'>";
											echo "<strong>Mérlegelés:</strong>";
											echo "</div>";
											echo "<div class='col-xs-6'>";
											echo "<a href='?contestview=".$data[DBData::$contestID]."&more=datacheck'><button type='button' class='btn btn-block btn-success'>Szerkesztés</button></a>";
											echo "</div>";
										}
										else {
											if($data[DBData::$contestIsEntry]){
												echo "<div class='col-xs-6'>
													<div class='alert alert-success' id='entryTitle'>Lehet nevezni</div>
													</div>";
												echo "<div class='col-xs-6'>
													<button class='btn btn-warning btn-block btn-responsive entryEnable' id='entryEnable'>Nevezési lehetőség bezárása</button>
												</div>";
											}
											else {
												echo "<div class='col-xs-6'>
													<div class='alert alert-danger' id='entryTitle'>Nem lehet még nevezni</div>
													</div>";
												echo "<div class='col-xs-6'>
													<button class='btn btn-warning btn-block btn-responsive entryClose' id='entryEnable'>Nevezési lehetőség engedélyazésa</button>

												</div>";
											}
										}

									}

									?>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php
					if($creator){
					    ?>
						<div class="panel-group" id="valami">
							<div class="panel panel-default">
								<div class="panel-heading" data-toggle="collapse" data-parent="#valami" href="#qwe">
									Nevezések
								</div>
								<div id="qwe" class="panel-collapse collapse in">
									<div class="panel-body">
										<button class="btn btn-default btn-block" type="button" id="checkEntryButton">Megtekintés</button>
									</div>
									<div id="checkEntryModalHire"></div>
								</div>
							</div>
						</div>
						<script>
						$("#checkEntryButton").click(function (e) {
							e.preventDefault();
							$.ajax({
								url:'Model/contestView/model_checkEntryMembers.php',
								type: 'POST',
								data: {contestID:<?php echo $_GET["contestview"]?>},
								dataType:'html'
							}).done(function(data){
								//console.log(data);
								$("#checkEntryModalHire").html(data);
								$("#checkEntryModal").modal("show");
							}).fail(function(){
								alert("Hiba!");
							});
						})
						</script>
						<?php
					}
				?>

			</div>

			<div class="col-md-3">
				<div class="panel-group" id="valami2">
					<div class="panel panel-default">
						<div class="panel-heading" data-toggle="collapse" data-parent="#valami2" href="#nevezes">
							Nevezés
						</div>
						<div id="nevezes" class="panel-collapse collapse in">
							<div class="panel-body">
								<div id="entryButton">
									<?php
									if($data[DBData::$contestDataChecks]){
											echo "<label>Végleg lezáródott a nevezés! A verseny jelenleg zajlik.</label>";
									}
									else {
										if($data[DBData::$contestIsEntry]){
											echo '<a href="?contestview='.$data[DBData::$contestID].'&more=entry" <button class="btn btn-default btn-block btn-responsive">Nevezem a szövetségi tagokat erre a versenyre</button></a>';
										}
										else {
											echo '<label>Sajnáljuk jelenleg nem lehet jelentkezni a versenyre</label>';
										}
									}

									?>
								</div>


							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="row">
							<div class="col-md-2 col-xs-4">Versenyszámok</div>
							<div class="col-md-8 col-xs-2"></div>
							<div class="col-md-2 col-xs-6">
								<?php
									if($creator&& !$data[DBData::$contestDataChecks]){
										echo '<button class="btn btn-default" data-toggle=\'modal\' data-target=\'#newComp\'>Új hozzáadása</button> ';
										include "View/contestView/Modal/modal_newCompetetion.php";

									}
								?>
							</div>

						</div>
					</div>

					<div class="row" style="margin: 10px;">
						<div class="col-md-1"></div>
						<div class="col-md-10">
							<?php
							if(isset($data[DBData::getCompetetionsTable()])){
								/** @var Competetion $item */
								$i =0;
								foreach ($data[DBData::getCompetetionsTable()] as $item) {
									$compid = $item->getId();
									?>
									<div class="panel-group" id="comp<?php echo $i?>">
										<div class="panel panel-info">
											<div class="panel-heading" data-toggle="collapse" data-parent="#comp<?php echo $i?>" href="#compCollapse<?php echo $i?>">
												<div class="row">
													<div class="col-md-2 col-xs-6"><?php echo $item->getTitle()?></div>
													<div class="col-md-6 col-xs-6">Verseny szám típusa: <?php echo $item->getType();
																			?></div>
													<div class="col-md-4 col-xs-12">
														<?php
															if($creator && !$data[DBData::$contestDataChecks]){
																?>
																	<button class='btn btn-info2 btn-block' data-toggle='modal' data-target='#myModal<?php echo $item->getId()?>'>Kategóriák hozzáadása</button>

																<?php
															}
														?>
													</div>
												</div>

											</div>
											<?php
											if($creator && !$data[DBData::$contestDataChecks]){
												include "View/contestView/Modal/modal_newCategorys.php";
											}
											?>
											<div id="compCollapse<?php echo $i?>" class="panel-collapse collapse in">
												<div class="panel-body">

												</div>
												<?php

												if(isset($compCat[$compid])){
													?>
													<div class="table-responsive">
														<table class="table table-stried table-hover table-bordered">
															<thead>
															<tr>
																<th>Életkor</th>
																<th>Nem Csoportok</th>
																<th>Csoport</th>

															</tr>
															</thead>
															<tbody>
															<?php
															/** @var CompCategory $value */
															foreach ($compCat[$compid] as $value) {
																echo "<tr>";
																echo "<td>".$value->getAgeMin()."-".$value->getAgeMax()."</td>";
																if($value->isSexWoman() || $value->isSexMan() || $value->isSexMixed() ||$value->isGroupFight()){
																	$group ="";
																	if($value->isSexWoman()){
																	    $group.="Női";
																	}
																	if($value->isSexMan()){
																	    if(strlen($group)>0){
																	        $group.=", ";
																	    }
																		$group.="Férfi";
																	}
																	if($value->isSexMixed()){
																		if(strlen($group)>0){
																			$group.=", ";
																		}
																		$group.="Vegyes";
																	}
																	if($value->isGroupFight()){
																		if(strlen($group)>0){
																			$group.=", ";
																		}
																		$group.="Csoportos mérkőzes";
																	}
																	echo "<td>".$group."</td>";
																}
																else {
																	echo "<td>Hiba! Nincs nem csoporthoz hozzáadva!</td>";
																}

																echo "<td>".$value->getPersonalGrpTitle()."</td>";
																echo "</tr>";
															}



															?>

															</tbody>
														</table>
													</div>
													<?php
												}
												else {
													?>
														<div class="row">
															<div class="col-xs-4"></div>
															<div class="col-xs-4 text-center">Nincsen kategória hozzáadva</div>
															<div class="col-xs-4"></div>
														</div>
													<?php
												}
												?>



											</div>
										</div>
									</div>
									<?php
									echo '';
									$i++;
								}
							}
							else {
								if($creator){
									echo "<div class='alert alert-warning text-center'>
										<p>Nincs Versenyszám hozzá adva a Versenyhez! Elindításhoz szükségesminimum egy! Hozzon létre egy újat!</p>
										</div>";
								}
								else {
									echo "<div class='alert alert-warning text-center'>
										<p>Nincs Versenyszám hozzá adva a Versenyhez!</p>
										</div>";
								}

							}

							?>

						</div>
						<div class="col-md-1"></div>
					</div>

				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(document).ready(function(){
		$("#entryEnable").on('click',function (e) {
			var id = $("#contestID").val();
			console.log(id+" enable");
			if ($(this).hasClass('entryEnable')){
				entryCloseFun(id, function(asd){
					console.log(asd);
					if(asd == "true" || asd== true){
						$("#entryTitle").removeClass("alert-success").addClass("alert-danger").text("Nem lehet még nevezni");
						$('.entryEnable').removeClass("entryEnable").addClass("entryClose");
						$('#entryEnable').text('Nevezési lehetőség engedélyezése');
						$("#entryButton").html('<label>Sajnáljuk jelenleg nem lehet jelentkezni a versenyre</label>');
					}
					else {
						console.log("Szívás");
					}
				});

			}
			else {

				entryEnableFun(id, function(asd){
					console.log(asd);
					if(asd == "true" || asd== true){
						$("#entryTitle").removeClass("alert-danger").addClass("alert-success").text("Lehet még nevezni");
						$('.entryClose').removeClass("entryClose").addClass("entryEnable");
						$('#entryEnable').text('Nevezési lehetőség bezárása');
						$("#entryButton").html('<a href="?contestview=<?php echo $data[DBData::$contestID]?>&entry=in" <button class="btn btn-default btn-block btn-responsive">Nevezem a szövetségi tagokat erre a versenyre</button></a>');


					}
					else {
						console.log("Szívás");
					}
				});
			}


			return;
		});
		function entryEnableFun(id, callback){
			$.post(
					"Model/contestView/model_ajax_EnrtyEnable.php",
					{id: parseInt(id)},
					function(data){
						callback(data);
					}
			);
		}
		function entryCloseFun(id, callback){
			$.post(
					"Model/contestView/model_ajax_EnrtyClose.php",
					{id: parseInt(id)},
					function(data){
						callback(data);
					}
			);
		}

	});
	function newPersonalGrp(id){
		var form = "newPersonalGrp"+id;


	}

</script>