<?php
if($clubleader){
	?>
	<div class="row">
		<div class="col-md-3"></div>
		<div class="col-md-6">
			<?php
			/** @var Organization $item */
			foreach ($club as $key => $item) {
				?>
				<div class="row form-group">
					<div class="col-xs-12 text-center">
						<?php echo $item->getName()?>
						<input type="hidden" name="orgId[]" value="<?php echo $item->getId()?>">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-xs-6 text-right"><strong>Egyesület neve</strong></div>
					<div class="col-xs-6"><input type="text" value="<?php echo $item->getName()?>" name="orgName[]" class="form-control"></div>
				</div>
				<div class="row form-group">
					<div class="col-xs-6 text-right"><strong>Rövidített név</strong></div>
					<div class="col-xs-6"><input type="text" value="<?php echo $item->getShortName()?>" name="orgShortName[]" class="form-control"></div>
				</div>
				<div class="row form-group">
					<div class="col-xs-6 text-right"><strong>Nyilvántartási szám</strong></div>
					<div class="col-xs-6"><abbr title="Nem változtatható meg"><strong><?php echo $item->getRegNum()?></strong></abbr></div>
				</div>
				<div class="row form-group">
					<div class="col-xs-6 text-right"><strong>Adó szám</strong></div>
					<div class="col-xs-6"><abbr title="Nem változtatható meg"><strong><?php echo $item->getTaxNum()?></strong></abbr></div>
				</div>
				<div class="row form-group">
					<div class="col-xs-6 text-right"><strong>Egyesület email címe</strong></div>
					<div class="col-xs-6"><abbr title="Nem változtatható meg"><strong><?php echo $item->getEmail();?></strong></abbr></div>
				</div>
				<div class="row form-group">
					<div class="col-xs-6 text-right"><strong>Telefon</strong></div>
					<div class="col-xs-6"><input type="tel" value="<?php echo $item->getTelefon()?>" name="orgTelefon[]" class="form-control"></div>
				</div>
				<div class="row form-group">
					<div class="col-xs-6 text-right"><strong>Fax</strong></div>
					<div class="col-xs-6"><input type="tel" value="<?php echo $item->getFaxNum()?>" name="orgFax[]" class="form-control"></div>
				</div>
				<div class="row form-group">
					<div class="col-xs-6 text-right"><strong>Weoldal címe</strong></div>
					<div class="col-xs-6"><input type="tel" value="<?php echo $item->getWebSite()?>" name="orgWebsite[]" class="form-control"></div>
				</div>
				<?php
				if(isset($club[$key])){
					echo "<hr>";
				}
			}
			?>

		</div>
		<div class="col-md-3"></div>
	</div>
	<?php


}
else{
	if($clubMember){
		?>
		<div class="row">
			<div class="col-md-3">
				<div class="form-group row">
					<div class="col-xs-12"><a href="?nav=myclub"><input type="button" class="btn btn-block btn-info" value="Tovább a Egyesületi tagsághoz"></a> </div>
				</div>
			</div>
			<div class="col-md-6">
				<?php
				/** @var Organization $item */
				foreach ($orgValue as $key => $item) {
					?>
					<div class="form-group row">
						<div class="col-xs-6 text-right"><strong>Egyesület neve</strong></div>
						<div class="col-xs-6"><a onclick="showModalOrg(<?php echo UserTasks::getUser()->getId().",".$item["orgId"]?>)"> <?php echo $item["orgName"]?></a></div>
					</div>
					<div class="form-group row">
						<div class="col-xs-6 text-right"><strong>Egyesület vezetője</strong></div>
						<div class="col-xs-6"><a onclick="showModalProfile(<?php echo UserTasks::getUser()->getId().",".$item["orgLeaderID"]?>)"> <?php echo $item["orgLeader"]?></a></div>
					</div>
					<?php
					if(isset($orgValue[$key])){
					    echo "<hr>";
					}
				}
				?>


			</div>
			<div class="col-md-3">

			</div>
		</div>
<?php
	}
	else {
		?>
		<div class="row">
			<div class="col-md-4"></div>
			<div class="col-md-4">
				<div class="row">
					<div class="col-md-12 text-center">
						<h3>Nincs Egyesülethez kapcsolva</h3>
						Létrehozhat egy újjat vagy csatlakozat is egyhez
					</div>
				</div>
				<div class="row form-group">
					<div class="col-md-12">
						<input type="submit" class="btn btn-default btn-block" name="createClub" id="createClub" value="Új létrehozása">
					</div>
				</div>
				<div class="row form-group">
					<div class="col-xs-12 text-center">
						Csatlakozás meglévőhöz
					</div>
				</div>
				<div class="row form-group">
					<div class="col-xs-12">
						<a href="?nav=club"><input type="button" class="btn btn-info btn-block" value="Keresés"></a>
					</div>
				</div>

			</div>
			<div class="col-md-4"></div>
		</div>
		<?php
	}
}