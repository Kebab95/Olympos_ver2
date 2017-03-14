<div class="panel panel-default">
	<div class="panel-body">
		<div class="row form-group">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-12">
						Csatlakozási szándékok ettől a szervezettől
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<select class="form-control" id="orgID">
							<?php
							/** @var Organization $org */
							foreach ($orgArray as $org) {
								echo "<option value='".$org->getId()."'>".$org->getName()."</option>";
							}
							?>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-4">

			</div>
		</div>
		<div class="row form-group">
			<div class="col-md-2"></div>
			<div class="col-md-8" id="requestList">
				<?php
				if(count($requestArray)>0){
					foreach ($requestArray as $item) {
						?>
							<div class="row form-group alert-info" style="padding: 10px">
								<div class="col-md-2 text-center" style="color:#000;">
									<?php echo $item["mu_name"]?>
								</div>
								<?php
								if(isset($item["fh_id"])){
									?>
									<div class="col-md-4">
										<button onclick="showModalOrg(<?php echo UserTasks::getUser()->getId().",".$item["fh_club_id"]?>)" type="button" class="btn btn-info2 btn-block">Profil</button>
									</div>
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-6">
												<button type="button" class="btn btn-success btn-block" onclick="requestSuccess(<?php echo $item["fh_fed_id"].",".$item["fh_club_id"].",".$item["fh_id"]?>)">Elfogadás</button>
											</div>
											<div class="col-md-6">
												<button type="button" class="btn btn-danger btn-block" onclick="requestDelete(<?php echo $item["fh_fed_id"].",".$item["fh_club_id"].",".$item["fh_id"]?>)">Vissza utasítás</button>
											</div>
										</div>
									</div>
									<?php
								}
								else {
									?>
									<div class="col-md-4">
										<button onclick="showModalProfile(<?php echo UserTasks::getUser()->getId().",".$item["ch_member_id"]?>)" type="button" class="btn btn-info2 btn-block">Profil</button>
									</div>
									<div class="col-md-6">
										<div class="row">
											<div class="col-md-6">
												<button type="button" class="btn btn-success btn-block" onclick="requestSuccess(<?php echo $item["ch_club_id"].",".$item["ch_member_id"].",".$item["ch_id"]?>)">Elfogadás</button>
											</div>
											<div class="col-md-6">
												<button type="button" class="btn btn-danger btn-block" onclick="requestDelete(<?php echo $item["ch_club_id"].",".$item["ch_member_id"].",".$item["ch_id"]?>)">Vissza utasítás</button>
											</div>
										</div>
									</div>
									<?php
								}
								?>

							</div>
						<?php
					}
				}
				else {
					?>
						<div class="row form-group">
							<div class="col-md-12 text-center">
								Nincsnek jelentkezési szándékok
							</div>
						</div>
					<?php
				}
				?>
			</div>
			<div class="col-md-2"></div>
		</div>
	</div>
</div>
<script>
	function requestDelete(orgID,memberID,chID){
		if(memberID!=null && chID!=null && orgID!=null){
			$.ajax({
				url:'Model/Inbox/model_ajax_deleteRequest.php',
				type: 'POST',
				data: {memberID:memberID,chID:chID,orgID:orgID,userID:<?php echo UserTasks::getUser()->getId()?>},
				dataType:'html'
			}).done(function(data){
				//console.log(data);
				$("#requestList").html(data);
			}).fail(function(){
				alert("Hiba!");
			});
		}
		else {
			alert("Hiba!");
		}

	}
	function requestSuccess(orgID,memberID,chID){
		if(memberID!=null && chID!=null && orgID!=null){
			$.ajax({
				url:'Model/Inbox/model_ajax_successRequest.php',
				type: 'POST',
				data: {memberID:memberID,chID:chID,orgID:orgID,userID:<?php echo UserTasks::getUser()->getId()?>},
				dataType:'html'
			}).done(function(data){
				//console.log(data);
				$("#requestList").html(data);
			}).fail(function(){
				alert("Hiba!");
			});
		}
		else {
			alert("Hiba!");
		}

	}
	$("#orgID").change(function(e){
		$.ajax({
			url:'Model/Inbox/model_load_orgRequest.php',
			type: 'POST',
			data: {orgID:$(this).val(),userID:<?php echo UserTasks::getUser()->getId()?>},
			dataType:'html'
		}).done(function(data){
			//console.log(data);
			$("#requestList").html(data);
		}).fail(function(){
			alert("Hiba!");
		});
	});
</script>