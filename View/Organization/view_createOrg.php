<div class="row" id="regOrgAll">
	<div class="col-lg-4 table-bordered" style="background-color: #f5f5f5">
		<div class="text-center">
			<label><?php echo orgOutput()?> regisztrálása után autómatikusan ön lesz a szervezet képviselője</label><br>
			<label>Ha új képviselőket szeretne hozzáadni majd a beállítások menü alatt <?php echo orgOutput()?> adatok menüpont alatt teheti meg</label><br>
			<span>Szervezet létrehozása után napokban hitelesítjük, hogy valós szervezetről van-e szó</span>
		</div>
	</div>
	<div class="center-block formWidth col-lg-8">
		<h2 class="text-center"><?php echo orgOutput()?> regisztrálása</h2>
		<form id="regOrgform" method="post">

			<div class="form-group row has-feedback">
				<label class="control-label col-sm-4 col-form-label" for="orgName"><?php echo orgOutput()?> Neve</label>
				<div class="col-sm-8">
					<input type="text" name="orgName" value="<?php echo (isset($_SESSION["orgName"])? $_SESSION["orgName"]: "");?>" id="orgName" required class="form-control">
				</div>

			</div>
			<div class="form-group row">
				<label class="col-sm-8 col-form-label" for="orgShortName">Rövídített Neve</label>
				<div class="col-sm-4"><input type="text" name="orgShortName" value="<?php echo (isset($_SESSION["orgShortName"])? $_SESSION["orgShortName"]: "");?>" id="orgShortName" required class="form-control"></div>
			</div>

			<div class="form-group row">
				<label class="col-sm-4 col-form-label" for="orgEmail">Email címe</label>
				<div class="col-sm-8"><input type="email" name="orgEmail" value="<?php echo (isset($_SESSION["orgEmail"])? $_SESSION["orgEmail"]: "");?>" id="orgEmail" required class="form-control"></div>
			</div>
			<hr>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Telefon száma</label>
				<div class="col-sm-4"><input type="tel" name="orgTel" value="<?php echo (isset($_SESSION["orgTel"])? $_SESSION["orgTel"]: "");?>" class="form-control"></div>
				<label class="col-sm-2 col-form-label">Fax száma <small>(Ha van)</small></label>
				<div class="col-sm-4"><input type="tel" name="orgFax" value="<?php echo (isset($_SESSION["orgFax"])? $_SESSION["orgFax"]: "");?>" class="form-control"></div>
			</div>
			<hr>

			<div class="form-group row">
				<label class="col-sm-4 col-form-label">Nyílvántartási szám</label>
				<div class="col-sm-8"><input type="text" name="orgRegNum" value="<?php echo (isset($_SESSION["orgRegNum"])? $_SESSION["orgRegNum"]: "");?>" required class="form-control"></div>
			</div>

			<div class="form-group row">
				<label class="col-sm-4 col-form-label">Adó szám</label>
				<div class="col-sm-8"><input type="text" name="orgTaxNum" value="<?php echo (isset($_SESSION["orgTaxNum"])? $_SESSION["orgTaxNum"]: "");?>" required class="form-control"></div>
			</div>
			<fieldset>
				<legend><?php echo orgOutput()?> Székhelye</legend>
				<div class="form-group row">
					<label class="col-lg-3 col-form-label">Irányítószám</label>
					<div class="col-lg-3"><input type="text" name="orgPCode" value="<?php echo (isset($_SESSION["orgPCode"])? $_SESSION["orgPCode"]: "");?>" required class="form-control"></div>
					<label class="col-lg-2 col-form-label">Település</label>
					<div class="col-lg-4"><input type="text" name="orgPTown" value="<?php echo (isset($_SESSION["orgPTown"])? $_SESSION["orgPTown"]: "");?>" required class="form-control"></div>

				</div>
				<div class="form-group row">
					<label class="col-sm-4 col-form-label">Utca, házszám</label>
					<div class="col-sm-8"><input type="text" name="orgPStreet" value="<?php echo (isset($_SESSION["orgPStreet"])? $_SESSION["orgPStreet"]: "");?>" required class="form-control"></div>
				</div>
			</fieldset>
			<hr>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label">Weboldal</label>
				<div class="col-sm-8"><input type="url" name="orgWebsite" value="<?php echo (isset($_SESSION["orgWebsite"])? $_SESSION["orgWebsite"]: "");?>" class="form-control"></div>
			</div>
			<div class="form-group row">
				<label class="col-sm-4 col-form-label">Leírása</label>
				<div class="col-sm-8" style="min-width: 100%;"><textarea class="form-control" rows="5" name="orgTitle" value="<?php echo (isset($_SESSION["orgTitle"])? $_SESSION["orgTitle"]: "");?>" style="min-width: 100%;resize:vertical;"></textarea> </div>
			</div>

			<div class="form-group text-center">
				<input type="submit" name="orgCreateSubmit" id="orgCreateSubmit" onclick="regOrg()" class="btn btn-default" value="Létrehozás">
				<input type="hidden" name="orgType" value="<?php echo orgTypeToNum(orgOutput())?>">
				<input type="hidden" name="orgUserID" value="<?php echo $_SESSION["User"]->getId()?>">
			</div>
			<?php echo $_SESSION["User"]->getId()?>
		</form>
		<?php
		function orgTypeToNum($text){
			if($text=="Szövetség"){
				return 2;
			}
			else if($text=="Egyesület"){
		        return 3;
			}
		}
		function orgOutput(){
			return ((isset($_SESSION["orgType"])?$_SESSION["orgType"]:"Hiba"));
		}
		?>
	<script>
		$('#regOrgform').submit(function(e){

			e.preventDefault(); // Prevent Default Submission
			$.ajax({
						url: 'model/model_regOrg.php',
						type: 'POST',
						data: $('#regOrgform').serialize(), // it will serialize the form data
						dataType: 'html'
					})
					.done(function(data){
						$('#regOrgAll').fadeOut('slow', function(){
							$('#regOrgAll').fadeIn('slow').html(data);
						});
					})
					.fail(function(){
						alert('Ajax Submit Failed ...');
					});
		});
	</script>
	</div>
</div>
