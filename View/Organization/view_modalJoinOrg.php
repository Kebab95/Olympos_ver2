<div class="modal fade" id="myModal" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-sm">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Csatlakozás</h4>
			</div>
			<div class="modal-body">
				<label>Biztos csatlakozni kíván a<br/>kiválasztott szervezethez?</label>
			</div>
			<div class="modal-footer center-block">
				<form action="" method="post" id="orgJoin">
					<input type="submit" onclick="orgJoinSubmit()" class="btn btn-success" value="Igen">
					<input type='hidden' name='orgIDHidden' value='<?php echo $item["orgId"]?>'>
					<button type="button" class="btn btn-default" data-dismiss="modal">Nem</button>
				</form>
			</div>
		</div>
	</div>
</div>