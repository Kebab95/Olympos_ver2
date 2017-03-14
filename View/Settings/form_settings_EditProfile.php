<?php /** @var SportUser $profUser */ ?>

<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<div class="row form-group">
			<div class="col-xs-6 text-right"><strong>Név</strong></div>
			<div class="col-xs-6">
				<input type="text" name="userName" class="form-control" value="<?php echo $profUser->getName()?>">
				<input type="hidden" name="userId" value="<?php echo $profUser->getId()?>">
			</div>
		</div>
		<div class="row form-group">
			<div class="col-xs-6 text-right"><strong>Email</strong></div>
			<div class="col-xs-6"><abbr title="Nem változtatható meg"><strong><?php echo $profUser->getEmail();?></strong></abbr></div>
		</div>
		<div class="row form-group">
			<div class="col-xs-6 text-right"><strong>Születés nap</strong></div>
			<div class="col-xs-6"><abbr title="Nem változtatható meg"><strong><?php echo $profUser->getBdate();?></strong></abbr></div>
		</div>
		<div class="row form-group">
			<div class="col-xs-6 text-right"><strong>Neme</strong></div>
			<div class="col-xs-6"><abbr title="Nem változtatható meg"><strong><?php echo $profUser->getSex();?></strong></abbr></div>
		</div>
		<div class="row form-group">
			<div class="col-xs-6 text-right"><strong>Telefon</strong></div>
			<div class="col-xs-6"><input type="text" name="userTelefon" class="form-control" value="<?php echo $profUser->getTelefon()?>"></div>
		</div>
		<hr>
		<div class="row form-group text-center">
			<div class="col-md-12"><strong>Sport Adatok</strong></div>
		</div>
		<?php
		if($isSportUser){
			?>
			<div class="row form-group">
				<div class="col-xs-6 text-right"><strong>Súly (Kg)</strong></div>
				<div class="col-xs-6"><input type="number" name="userSportWeight" class="form-control" value="<?php echo $profUser->getWeight()?>"></div>
			</div>
			<div class="row form-group">
				<div class="col-xs-6 text-right"><strong>Öv fokozat</strong></div>
				<div class="col-xs-6"><?php echo "<strong>".$profUser->getBeltGrades()."</strong><br>(Öv fokozatott a egyesület vezető változatja meg)"?></div>
			</div>
			<?php
		}
		else {
			?>
			<div class="row">
				<div class="col-xs-12 text-center">
					Nincsen Sport adat hozzá kapcsolva ehez a felhasználóhoz
				</div>
			</div>
			<?php

		}
		?>
		<hr>
		<div class="row form-group text-center">
			<div class="col-md-12">
				Jogosultsági tábla
			</div>
		</div>
		<div class="row form-group">
			<div class="col-xs-6 text-right">Admin</div>
			<div class="col-xs-6 "><span class="<?php echo $profUser->isAdmin()?"glyphicon glyphicon-ok text-success":"glyphicon glyphicon-remove text-danger"?>"></span> </div>
		</div>
		<div class="row form-group">
			<div class="col-xs-6 text-right">Moderator</div>
			<div class="col-xs-6 "><span class="<?php echo $profUser->isModerator()?"glyphicon glyphicon-ok text-success":"glyphicon glyphicon-remove text-danger"?>"></span> </div>
		</div>
		<div class="row form-group">
			<div class="col-xs-6 text-right">Szövetségi vezető</div>
			<div class="col-xs-6 "><span class="<?php echo $profUser->isFederationLeader()?"glyphicon glyphicon-ok text-success":"glyphicon glyphicon-remove text-danger"?>"></span> </div>
		</div>
		<div class="row form-group">
			<div class="col-xs-6 text-right">Egyesületi vezető</div>
			<div class="col-xs-6 "><span class="<?php echo $profUser->isClubLeader()?"glyphicon glyphicon-ok text-success":"glyphicon glyphicon-remove text-danger"?>"></span> </div>
		</div>
		<div class="row form-group">
			<div class="col-xs-6 text-right">Szövetségi tag</div>
			<div class="col-xs-6 "><span class="<?php echo $profUser->isFedMember()?"glyphicon glyphicon-ok text-success":"glyphicon glyphicon-remove text-danger"?>"></span> </div>
		</div>
		<div class="row form-group">
			<div class="col-xs-6 text-right">Egyesületi tag</div>
			<div class="col-xs-6 "><span class="<?php echo $profUser->isMember()?"glyphicon glyphicon-ok text-success":"glyphicon glyphicon-remove text-danger"?>"></span> </div>
		</div>
		<div class="row form-group">
			<div class="col-xs-6 text-right">Edző</div>
			<div class="col-xs-6 "><span class="<?php echo $profUser->isTrainer()?"glyphicon glyphicon-ok text-success":"glyphicon glyphicon-remove text-danger"?>"></span> </div>
		</div>
	</div>
	<div class="col-md-3"></div>
</div>