<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
			<div class="col-xs-4"></div>
			<div class="col-xs-4 text-center">
				<h4><?php echo $data[DBData::$contestName];?></h4>
			</div>
			<div class="col-xs-4">
				<?php
				if($data[DBData::$contestClosed]){
					?>
					<label class="label-danger">Lezáródtt a verseny</label>
					<?php
				}
				else if($data[DBData::$contestDataChecks]){
					?>
					<label class="label-info">Zajlik a verseny</label>
					<?php
				}
				else if($data[DBData::$contestIsEntry]){
					?>
					<label class="label-info">Nevezési fázis</label>
					<?php
				}
				else {
					?>
						<label class="label-info">Szerkesztés alatt</label>
					<?php
				}
				?>
			</div>
		</div>

	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-3">
				<?php
				if($creator){
					if($data[DBData::$contestClosed]){
						?>
						<div class="row form-group">
							<div class="col-xs-12">
								<a href='?contestview=<?php echo $data[DBData::$contestID]?>&more=closed'><button class='btn btn-info btn-block'>Lejátszott futamok</button></a>
							</div>
						</div>
						<?php
					}
					else if($data[DBData::$contestDataChecks]){
						?>
							<div class="row form-group">
								<div class="col-xs-12">
									<a href='?contestview=<?php echo $data[DBData::$contestID]?>&more=datacheck'><button type='button' class='btn btn-block btn-success'>Mérlegelés</button></a>
								</div>
							</div>
						<div class="row form-group">
							<div class="col-xs-12">
								<a href='?contestview=<?php echo $data[DBData::$contestID]?>&more=schedule'><button type="button" class='btn btn-info btn-block'>Versenyszámok beosztása</button></a>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-12">
								<a href='?contestview=<?php echo $data[DBData::$contestID]?>&more=closed'><button class='btn btn-info btn-block'>Lejátszott futamok</button></a>
							</div>
						</div>
						<hr>
						<div class="row form-group">
							<div class="col-xs-12">
								<button class='btn btn-warning btn-block' onclick="closeContest(<?php echo $_GET["contestview"]?>)">Verseny lezárása</button>
							</div>
							<div class="col-xs-12 text-justify">
								<label>Csak akkor tudja lezárni a vesenyt ha minden versenyszám futama lezárult!</label>
							</div>
						</div>
						<script>
							function closeContest(contestID){
								$.ajax({
									url:'Model/contestView/closed/model_ajax_closeContest.php',
									type: 'POST',
									data: {contestID:contestID},
									dataType:'html'
								}).done(function(data){
									if(data==2 || data=="2"){
										alert("Verseny sikeresen lezárva");
										location.reload();
									}
									else if(data==0 || data=="0"){
										alert("Nem sikerült lezártni a Versenyt mert vannak még lezáratlan versenyszámok.");
									}
									else if(data==1 || data=="1"){
										alert("Hiba esett a verseny lezárásánál");
									}
								}).fail(function(){
									alert("Hiba!");
								});
							}
						</script>
						<?php
					}
					else if($data[DBData::$contestIsEntry]){
						if($data["entryCount"]==0){
							?>
							<div class="row form-group">
								<div class="col-xs-12">
									<button class="btn btn-danger btn-block entryEnable" id="entryEnable">Nevezés visszavonása</button>
								</div>
							</div>
							<?php
						}
						?>
							<div class="row form-group">
								<div class="col-xs-12">
									<button class="btn btn-info2 btn-block" id="dataChecksButton">Nevezés lezárása</button>
								</div>
							</div>
							<div class="row">
								<div class="col-xs-12">
									<label>Nevezés lezárás után megjelnik a mérlegelés menüpont, verseny beosz</label>
								</div>
							</div>
						<?php
					}
					else {
						?>
						<div class="row form-group">
							<div class="col-xs-12">
								<button class='btn btn-default btn-block'>Szerkesztés</button>
							</div>
						</div>
						<div class="row form-group">
							<div class="col-xs-12">
								<button class="btn btn-info2 btn-block entryClose" id="entryEnable">Nevezés megnyitása</button>
							</div>
						</div>
						<div class="row">
							<div class="col-xs-12 text-justify">
								<label>Ha megnyitja a nevezést, addig vissza tudja majd vonni ameddig megnem érkezik az első nevezés</label>
							</div>
						</div>
						<?php
					}
				    ?>

					<?php
				}
				else {
						if($data[DBData::$contestClosed]){
								?>
							<div class="row form-group">
								<div class="col-xs-12">
									<a href='?contestview=<?php echo $data[DBData::$contestID]?>&more=closed'><button class='btn btn-info btn-block'>Lejátszott futamok</button></a>
								</div>
							</div>
						<?php
						}
						else if($data[DBData::$contestDataChecks]){
						?>
							<div class="row form-group">
								<div class="col-xs-12">
									<a href='?contestview=<?php echo $data[DBData::$contestID]?>&more=closed'><button class='btn btn-info btn-block'>Lejátszott futamok</button></a>
								</div>
							</div>

							<?php
						}
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
									<label class="col-xs-6 text-right"><strong>Szervező szervezet</strong></label>
									<label class="col-xs-6 ">
										<a onclick="showModalOrg(<?php echo UserTasks::getUser()->getId().",".$data[DBData::$contestOrgID]->getId()?>)">
											<?php echo $data[DBData::$contestOrgID]->getName()?>
										</a>
									</label>
								</div>
								<div class="row">
									<label class="col-xs-6 text-right"><strong>Helyszín</strong></label>
									<label class="col-xs-6 "><?php echo $data[DBData::$contestLocaleID]?></label>
								</div>
								<div class="row">
									<label class="col-xs-6 text-right">Dátum</label>
									<label class="col-xs-6"><?php echo $data[DBData::$contestDate]?></label>
								</div>
								<div class="row">
									<label class="col-xs-6 text-right">Alap nevezési díj</label>
									<label class="col-xs-6"><?php echo $data[DBData::$contestEntryFee]?></label>
								</div>
								<div class="row">
									<label class="col-xs-6 text-right">Leírás</label>
									<label class="col-xs-6"><?php echo $data[DBData::$contestDesc]?></label>
								</div>
								<div class="row">





									<input type='hidden' name='contestID' id="contestID" value="<?php echo $data[DBData::$contestID]?>">
									<?php
									if($creator){


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
				<div class="row">
					<div class="col-md-12">
						<div class="panel-group" id="valami2">
							<div class="panel panel-default">
								<div class="panel-heading" data-toggle="collapse" data-parent="#valami2" href="#nevezes">
									Nevezés
								</div>
								<div id="nevezes" class="panel-collapse collapse in">
									<div class="panel-body">
										<div id="entryButton" class="text-justify">
											<?php
											if($data[DBData::$contestDataChecks]){
												echo "<label>Végleg lezáródott a nevezés! A verseny jelenleg zajlik.</label>";
											}
											else {
												if($data[DBData::$contestIsEntry] && UserTasks::isClubLeader()){
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
					<?php
					if($creator && $data[DBData::$contestDataChecks]){
						?>
							<div class="col-md-12">
								<div class="panel panel-default" id="jegyzo">
									<div class="panel-heading" data-toggle="collapse" data-parent="#jegyzo" href="#jegyz">
										Jegyzők kezelése
									</div>
									<div id="jegyz" class="panel-collapse collapse">
									<div class="panel-body">
										<div id="administratorsList">
											<?php
											if(count($administratorArray)>0){
												foreach ($administratorArray as $admin) {
													?>
														<div class="row">
															<div class="col-md-6"><?php echo $admin[DBData::$adminName] ?></div>
															<div class="col-md-3"><?php echo $admin[DBData::$adminGenCode] ?></div>
															<div class="col-md-3"><span onclick="removeAdmin(<?php echo $admin[DBData::$adminID]?>)" class="glyphicon glyphicon-remove"></span> </div>
														</div>
													<?php
												}
												echo "<hr>";
											}
											?>
										</div>


										<button type="button" id="newAdministratorButton" class="btn btn-success btn-block" data-toggle='modal' data-target='#AdministratorModal'>Új hozzáadása</button>

										<div class="modal fade " id="AdministratorModal" role="dialog">
											<div class="modal-dialog">
												<div class="modal-content">
													<div class="modal-header">Új Adminisztrátor hozzáadása</div>
													<div class="modal-body">
														<div class="row text-center">
															A jegyző vezető ezen a linken tud majd belépni:<br>
															<label><?php echo ((isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]")."&more=adminLogin";?></label>
															<p>Kérjük figyeljen a belépési kódra! Kódnak tudatában bárki be tud lépni a verseny szerkesztésébe! Ennek fényébe kérjük ügyeljen a biztonságra!</p>
														</div>
														<div class="row form-group">
															<div class="col-md-6">Név:</div>
															<div class="col-md-6"><input type="text" class="form-control" id="adminAddName"></div>
														</div>
														<div class="row form-group">
															<div class="col-md-6">Belépési kód:</div>
															<div class="col-md-6"><p id="adminAddgenCode"></p></div>
														</div>
														<div class="row form-group">
															<div class="col-md-12"><button type="button" id="adminAddSubmit" class="btn btn-block btn-default">Hozzáadás</button></div>
														</div>
													</div>
												</div>
											</div>
										</div>
										<script>
											function removeAdmin(id){
												$.ajax({
													url:'Model/contestView/model_ajax_removeAdministrator.php',
													type: 'POST',
													data: {adminID: id,
														contestID: <?php echo $_GET["contestview"]?>},
													dataType:'html'
												}).done(function(data){
													$("#administratorsList").html(data);
												}).fail(function(){
													alert("Hiba!");
												});
											}
											$("#newAdministratorButton").click(function(e){
												$("#adminAddgenCode").text(makeid());
											});
											$("#adminAddSubmit").click(function(e){
												var name = $("#adminAddName").val();
												var genCode = $("#adminAddgenCode").text();
												if (name.length>0 && genCode.length>0){
													$.ajax({
														url:'Model/contestView/model_ajax_newAdministrator.php',
														type: 'POST',
														data: {name:name,
															genCode:genCode,
															contestID: <?php echo $_GET["contestview"]?>},
														dataType:'html'
													}).done(function(data){
														//console.log(data);
														$("#administratorsList").html(data);
														$("#AdministratorModal").modal('toggle');
													}).fail(function(){
														alert("Hiba!");
													});
												}
												else {
													alert("Üresen hagyott mezőt találtam!")
												}

											});
											function makeid()
											{
												var text = "";
												var possible = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";

												for( var i=0; i < 5; i++ )
													text += possible.charAt(Math.floor(Math.random() * possible.length));
												return text;
											}
										</script>
									</div>
									</div>
								</div>
							</div>

						<?php
					}
					?>
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
									if($creator&& !$data[DBData::$contestDataChecks] && !$data[DBData::$contestIsEntry]){
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
															if($creator && !$data[DBData::$contestDataChecks] && !$data[DBData::$contestIsEntry]){
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
											<div id="compCollapse<?php echo $i?>" class="panel-collapse collapse">
												<div class="panel-body">

												</div>
												<?php

												if(isset($compCat[$compid])){
													?>
													<div class="table-responsive">
														<table class="table  table-hover table-bordered">
															<thead>
															<tr>
																<th>Életkor</th>
																<th>Nem Csoportok</th>
																<th>Csoport</th>

															</tr>
															</thead>
															<tbody>
															<?php
															$age = array(0,0);
															$change = true;
															/** @var CompCategory $value */
															foreach ($compCat[$compid] as $value) {
																if($age[0] !=$value->getAgeMin() && $age[1]!=$value->getAgeMax()){
																	$change = !$change;
																	$age[0] = $value->getAgeMin();
																	$age[1] = $value->getAgeMax();
																}
																echo "<tr style='background-color: ".($change?"#4F79A1":"#4E5D6C")."'>";

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
	$("#dataChecksButton").click(function(){
		$.ajax({
			url:"Model/contestView/model_ajax_dataChecksFlag.php",
			type: "POST",
			data: {contestID:<?php echo $data[DBData::$contestID] ?>,
				flag:<?php echo (!$data[DBData::$contestDataChecks]?"true":"false")?>},
			dataType:"text"
		}).done(function(data){
			//console.log(data);
			location.reload();
		}).fail(function(){
			alert("asd");
		});
	});
	$(document).ready(function(){

		$("#entryEnable").on('click',function (e) {
			var id = $("#contestID").val();
			console.log(id+" enable");
			if ($(this).hasClass('entryEnable')){
				entryCloseFun(id, function(asd){
					//console.log(asd);
					if(asd == true){
						location.reload();
						//$("#entryTitle").removeClass("alert-success").addClass("alert-danger").text("Nem lehet még nevezni");
						//$("#entryButton").html('<label>Sajnáljuk jelenleg nem lehet jelentkezni a versenyre</label>');
					}
					else {
						console.log("Szívás");
					}
				});
				//location.reload();

			}
			else {

				entryEnableFun(id, function(asd){
					console.log(asd);
					if(asd == true){
						location.reload();
						//$("#entryTitle").removeClass("alert-danger").addClass("alert-success").text("Lehet még nevezni");
						//$("#entryButton").html('<a href="?contestview=<?php echo $data[DBData::$contestID]?>&entry=in" <button class="btn btn-default btn-block btn-responsive">Nevezem a szövetségi tagokat erre a versenyre</button></a>');


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