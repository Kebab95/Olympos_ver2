<div id="regAll">
	<div class="container text-center regWelcome success">
		<h1>Regisztráció</h1>
	</div>

	<div class="row">
		<div class="col-md-2"></div>
		<form id="regForm" class="col-md-8 center-block text-center " method="post" >
			<div class="col-md-12">
				<div class="row form-group">
					<div class="col-xs-4 col-md-4">
						<label for="regName" class="control-label">Teljes név</label>
					</div>
					<div class="col-xs-8 col-md-8">
						<input required type="text" id="regName" name="name" value="<?php echo (isset($_SESSION["regName"])? $_SESSION["regName"]: "");?>" class="form-control">

					</div>

				</div>
			</div>
			<div class="col-md-12">
				<div class="row form-group">
					<div class="col-xs-4 col-md-4">
						<label for="regEmail" class="control-label">Email cím</label>
					</div>
					<div class="col-xs-8 col-md-8">
						<input required type="email" id="regEmail" name="email" value="<?php echo (isset($_SESSION["regEmail"])? $_SESSION["regEmail"]: "");?>" class="form-control">

					</div>

				</div>
			</div>
			<div class="col-md-12">
				<div class="row form-group">
					<div class="col-xs-4 col-md-4">
						<label for="regTel" class="control-label">Telefon</label>
					</div>
					<div class="col-xs-8 col-md-8">
						<input required type="text" id="regTel" value="<?php echo (isset($_SESSION["regTel"])? $_SESSION["regTel"]: "");?>" name="tel" class="form-control ">

					</div>

				</div>
			</div>
			<div class="col-md-12">
				<div class="row form-group">
					<div class="col-md-4">
						<label class="control-label">Születés nap:</label>
					</div>
					<div class="col-md-8">
						<input type="date" name="bday" class="form-control">
					</div>
				</div>
			</div>
			<div class="col-md-12">
				<div class="row form-group">
					<div class="col-md-4">
						<label class="control-label">Neme:</label>
					</div>
					<div class="col-md-8">
						<select required class="form-control" name="nem">
							<option value=""></option>
							<option value="0">Férfi</option>
							<option value="1">Nő</option>
						</select>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="row form-group">
					<div class="col-xs-4 col-md-5">
						<label for="regPass" class="control-label">Jelszó</label>
					</div>
					<div class="col-xs-8 col-md-7" id="passVal1">
						<input required type="password" id="regPass" onkeyup="passVal()" name="pass" class="form-control">

						<span class="help-block">Minimum 6 karakter, egy szám valamint kis és NAGY betűk</span>
					</div>

				</div>
			</div>

			<div class="col-md-6">
				<div class="row form-group">
					<div class="col-xs-4 col-md-5">
						<label for="regPass2" class="control-label">Jelszó ismét</label>
					</div>
					<div class="col-xs-8 col-md-7" id="passVal2">
						<input required type="password" id="regPass2" onkeyup="passVal()" name="pass2" class="form-control">

						<span id="passAlert" style="display: none" class="help-block">Nem eggyeznek a jelszavak</span>
					</div>

				</div>
			</div>
			<div class="col-md-12">
				<input type="submit" class="btn btn-success" name="regsub" id="regsub" value="Regisztráció">
			</div>
		</form>
		<div class="col-md-2"></div>
	</div>
</div>
<script>
	$('#regForm').submit(function(e){

		e.preventDefault(); // Prevent Default Submission
		$.ajax({
			url:"Model/model_regSubmit.php",
			type: "POST",
			data: $(this).serialize(),
			dataType:"html"
		}).done(function (data){
			$("#regAll").html(data);
		}).fail(function(){
			alert("Hiba!");
		});

	});
</script>

