<div class="modal fade" id="myModal<?php echo $modalNum?>" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<form action="" method="post" id="orgJoin<?php echo $modalNum?>">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Csatlakozás</h4>
				</div>
				<div class="modal-body">
					<label>Biztos csatlakozni kíván a<br/>kiválasztott szervezethez?</label>

					<?php
					if($_GET["nav"]=="fed"){
					    $orgs = DBLoad::loadOrgLeader(UserTasks::getUser()->getId(),3);
						echo "<label>Válassza ki a csatlakozni kívánt Egyesületett</label>";
						?>
							<select class="form-control" name="orgID">
								<?php
								/** @var Organization $org */
								foreach ($orgs as $org) {
									echo "<option value='".$org->getId()."'>".$org->getName()."</option>";
								}
								?>
							</select>
						<?php
					}
					?>
				</div>
				<div class="modal-footer center-block">

						<input type="submit" class="btn btn-success" onclick="orgJoinSubmit(<?php echo $modalNum?>)" value="Igen">
						<input type='hidden' name='orgIDHidden' value='<?php echo $item["orgId"]?>'>
						<button type="button" class="btn btn-default" data-dismiss="modal">Nem</button>

				</div>
			</form>
		</div>
	</div>
</div>