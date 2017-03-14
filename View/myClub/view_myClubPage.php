<?php
foreach ($orgValue as $item) {
	?>
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo $item["orgName"]?></div>
		<div class="panel-body">
			<div class="row center-block text-center">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<label>Egyesület képviselő neve:</label>
					<a onclick="showModalProfile(<?php echo UserTasks::getUser()->getId()?>,<?php echo $item["orgLeaderID"]?>)"><?php echo $item["orgLeader"]?></a>
				</div>
				<div class="col-md-4">
					<?php
					if($isLeader){
						echo "<button class='btn btn-success' data-toggle='modal' data-target='#myModal".$temp["orgId"]."'>Új tag hozzáadása</button>";
						?>
						<div class="modal fade" id="myModal<?php echo $temp["orgId"]?>" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Új tag hozzáadása</h4>
									</div>
									<div class="modal-body">
										<ul class="nav nav-tabs">
											<li class="nav active"><a href="#A" data-toggle="tab">Új felhasználó</a></li>
											<li class="nav"><a href="#B" data-toggle="tab">Keresés</a></li>
										</ul>
										<div class="tab-content">
											<div class="tab-pane fade in active" id="A">
												<div class="row">
													<div class="col-xs-12">
														<label>Létrehozott tag után használni lehet az adott profilt, ha most vagy később hozzá rendel egy email címet, a taghoz.
															Ez esetben ki küldünk egy regisztrációs email-t a szeélynek és már be is tud jelentkezni, szerkeszteni a profil adatait.</label>
													</div>
												</div>
												<hr>
												<form method="post" id="newMember<?php echo $item["orgId"]?>">
													<div class="row form-group">
														<div class="col-xs-6"><strong role="#memberName">Teljes Név</strong></div>
														<div class="col-xs-6"><input type="text" class="form-control" id="memberName" name="memberName" required></div>
													</div>
													<hr>
													<div class="row form-group">
														<div class="col-xs-6">Születés nap</div>
														<div class="col-xs-6"><input type="date" class="form-control" name="memberBDate"></div>
													</div>
													<hr>
													<div class="row form-group">
														<div class="col-md-6">Neme: </div>
														<div class="col-md-6"><select required class="form-control" name="nem">
																<option value=""></option>
																<option value="0">Férfi</option>
																<option value="1">Nő</option>
															</select></div>
													</div>
													<hr>
													<div class="row form-group">
														<div class="col-xs-6">Email</div>
														<div class="col-xs-6"><input type="email" class="form-control" name="memberEmail"></div>
													</div>
													<div class="row">
														<div class="col-md-4"></div>
														<div class="col-md-4">
															<input type="hidden" value="<?php echo $item["orgId"]?>" name="memberOrgId">
															<input type="submit" onclick="newMemberFunc(<?php echo $item["orgId"]?>)" value="Hozzáadás" id="memberSub" class="btn btn-success">
														</div>
														<div class="col-md-4"></div>
													</div>
												</form>
											</div>
											<div class="tab-pane fade" id="B">Content inside tab B</div>
										</div>

									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>

							</div>
						</div>
						<script src="Model/myClub/js_newMember.js">	</script>
						<?php
					}
					?>
				</div>
			</div>

			<div class="row center-block text-center">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<input onclick="showModalOrg(<?php echo UserTasks::getUser()->getId().",".$item["orgId"]?>)" type="button" class="btn btn-default" value="További Adatok">
				</div>
				<div class="col-md-4"></div>
			</div>


		</div>
		<div class="row">
			<div class="col-xs-12 table-responsive">
				<table class="table table-striped table-hover table-bordered ">
					<thead>
					<tr>
						<th>Tag Neve</th>
						<th>Utoljára mért Súlya</th>
						<th>Öv fokozat</th>
						<th>Életkor</th>
						<th></th>
						<?php echo ($isLeader?"<th></th>":"")?>
						<?php echo ($isLeader?"<th></th>":"")?>

					</tr>
					</thead>
					<tbody>
					<?php
					if(is_array($item["members"])) {
						foreach ($item["members"] as $member) {
							/** @var SportUser $User */
							$User = $member["memberUser"];
							echo "<tr ".($member["memberCurrent"]?"class='info'":"")." id='clubMemberRow".$User->getId()."'>";
							echo "<td>".$User->getName()."</td>";
							if(SportUser::isSportUser($User)){
								echo "<td>".$User->getWeight()."</td>";
								echo "<td>".$User->getBeltGrades()."</td>";

							}
							else {
								echo "<td colspan='2'>Nincsenek sport adatai ennek a felhasználónak</td>";
							}
							echo "<td>".$User->getAge()."</td>";
							if($isLeader){
								echo "<td><button onclick='sportDataUpdate(".$User->getId().")' class='btn btn-info2 btn-block'>Sport Adatok Frissítése</button></td>";
							}


							if($User->getEmail()!=null){
								echo "<td><button class='btn btn-info btn-block' onclick='showModalProfile(".UserTasks::getUser()->getId().",".$User->getId().")'>Profil</button> </td>";
							}
							else {
								if($isLeader){
									echo "<td><input type='button' class='btn btn-info btn-block' value='Létrehozás'></td>";
								}
								else {
									echo "<td>Nem regisztrált Felhasználó</td>";
								}

							}


							if($isLeader){
								echo "<td><button class='btn btn-danger btn-block'>Tag törlése</button> </td>";
							}
							echo "</tr>";
							/*
							echo "<tr ".($member["memberCurrent"]?"class='info'":"").">";
							echo "<td>" . $User->getName() . "</td>";
							echo "<td>" . ($User->getTelefon()!=null?$User->getTelefon():"<div class='center-block text-center'>
										<label>Ennek a profilnak nincsenek egyéb adataia</label>
										</div>") . "</td>";
							echo "<td>".($User->getTelefon()!=null?"<a href='?profile=".$User->getId()."'>Tovább a profilhoz</a>":"<input type='button' class='btn btn-info' value='Létrehozás'>")."</td>";
							echo ($isLeader?"<td><button class='btn btn-danger'>Tag törlése</button> </td>":"");
							echo "</tr>";
							*/
						}
					}
					else {
						echo "<tr>
									<td colspan='3' class='text-center'>Hiba vagy nincs tag</td>
									</tr>";
					}
					?>
					</tbody>
				</table>
			</div>
		</div>

	</div>
	<hr>
	<div id="sportDataUpdateDiv"></div>

	<?php
}
?>
<script>
	function sportDataUpdate(memberID){
		$.ajax({
			url: 'Model/myClub/model_ajax_sportMemberUpdateModal.php',
			type: 'POST',
			data: {memberID: memberID},
			dataType: 'html'
		}).done(function(data){
			console.log(data);
			$("#sportDataUpdateDiv").html(data);
			$("#sportUserUpdateModal").modal("show").on('hidden.bs.modal', function () {
				setTimeout(function(){
					$("#sportDataUpdateDiv").html("");
				},500);
			});
			$("#sportUserSubmit").on("click",function(){
				$.ajax({
					url: 'Model/myClub/model_ajax_sportMemberUpdate.php',
					type: 'POST',
					data: {memberID: memberID,
							weight:$("#sportUserWeight").val(),
							beltGradesID: $("#sportUserBeltID").val(),
							upOrin: $("#insertOrUpdateSportMember").val(),
							updaterID: <?php echo UserTasks::getUser()->getId()?>,
							isClubLeader: <?php echo UserTasks::isClubLeader()?>},
					dataType: 'html'
				}).done(function(html){
					console.log(html);
					if(html!="false"){
						$("#sportUserUpdateModal").modal("toggle");
						setTimeout(function(){
							$("#clubMemberRow"+memberID).html(html);
						},500);
					}
					else {
						alert("Nem töltött ki minden mezőt!");
					}

				}).fail(function(){
					alert('Ajax Submit Failed ...');
				});
			});
			$("#sportUserUpdateModalClose").on("click",function(){
				$("#sportUserUpdateModal").modal("toggle");

				setTimeout(function(){
					$("#sportDataUpdateDiv").html("");
				},500);

			});

		}).fail(function(){
			alert('Ajax Submit Failed ...');
		});
	}
</script>
