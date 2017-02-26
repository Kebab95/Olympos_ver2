<div class="row">
	<div class="col-xs-1 col-md-4"></div>
	<div class="col-xs-10 col-md-4">
		<div class="panel <?php echo ($profEdit?"panel-info":"panel-default")?> center-block">
			<div class="panel-heading">
				Profil
			</div>
			<div class="panel-body">
				<div class="row center-block text-center">
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
			</div>
		</div>
	</div>
	<div class="col-xs-1 col-md-4"></div>
</div>

