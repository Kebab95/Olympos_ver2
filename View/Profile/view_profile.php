<div class="row regInputs center-block text-center">
	<div class="col-md-6 col-xs-6">
		<strong>Név</strong>
	</div>
	<div class="col-md-6 col-xs-6">
		<?php echo $profName;?>
	</div>
	<div class="col-md-6 col-xs-6">
		<strong>Email</strong>
	</div>
	<div class="col-md-6 col-xs-6">
		<?php echo $profEmail;?>
	</div>
	<div class="col-md-6 col-xs-6">
		<strong>Telefon</strong>
	</div>
	<div class="col-md-6 col-xs-6">
		<?php echo $profTel;?>
	</div>
	<div class="col-md-6 col-xs-6">
		<strong>Születésnap</strong>
	</div>
	<div class="col-md-6 col-xs-6">
		<?php echo $profBDate;?>
	</div>
	<?php
	if($profEdit){
	    ?><form method='post' action=''>
			<div class='col-md-12 col-xs-12'>
				<input type='submit' name="editProfile" value='Profil szerkesztése' class='btn btn-info'/>
			</div>
		</form><?php
	}

	?>
</div>