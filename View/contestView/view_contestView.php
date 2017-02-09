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
										<button class="btn btn-default btn-block">Megtekintés</button>
									</div>
								</div>
							</div>
						</div>
						<?php
					}
				?>

			</div>

			<div class="col-md-3"></div>

			<div class="col-md-12">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="row">
							<div class="col-xs-2">Versenyszámok</div>
							<div class="col-xs-8"></div>
							<div class="col-xs-2"><button class="btn btn-default">Új hozzáadása</button> </div>
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
									echo '<div class="panel-group" id="comp'.$i.'">
											<div class="panel panel-info">
												<div class="panel-heading" data-toggle="collapse" data-parent="#comp'.$i.'" href="#compCollapse'.$i.'">
													'.$item->getTitle().'
												</div>
												<div id="compCollapse'.$i.'" class="panel-collapse collapse in">
													<div class="panel-body">
														Kategóriák
													</div>
												</div>
											</div>
										</div>';
									$i++;
								}
							}
							else {
								echo "<div class='alert alert-warning text-center'>
										<p>Nincs Versenyszám hozzá adva a Versenyhez! Elindításhoz szükségesminimum egy! Hozzon létre egy újat!</p>
										</div>";
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
	})

</script>