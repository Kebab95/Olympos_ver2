<form method="post" action="" id="settingsForm">
	<h2>Beállítások</h2>
	<div class="panel-group" id="accordion">
		<div class="panel panel-info">
			<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse1">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse1">Felhasználói adatok</a>
				</h4>
			</div>
			<div id="collapse1" class="panel-collapse collapse <?php echo isset($_GET["open"])&& $_GET["open"]=="profile"?"in":""?>">
				<div class="panel-body">
					<?php include "View/Settings/form_settings_EditProfile.php";?>
				</div>
			</div>
		</div>
		<div class="panel panel-default">
			<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse2">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse2">Egyesületi adatok</a>
				</h4>
			</div>
			<div id="collapse2" class="panel-collapse collapse <?php echo isset($_GET["open"])&& $_GET["open"]=="club"?"in":""?>">
				<div class="panel-body">
					<?php
						include "View/Settings/form_settings_EditClub.php";
					?>
				</div>
			</div>
		</div>
		<div class="panel panel-default" >
			<div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#collapse3">
				<h4 class="panel-title">
					<a data-toggle="collapse" data-parent="#accordion" href="#collapse3">Szövetségi adatok</a>
				</h4>
			</div>
			<div id="collapse3" class="panel-collapse collapse <?php echo isset($_GET["open"])&& $_GET["open"]=="fed"?"in":""?>">
				<div class="panel-body">
					<?php
						include "View/Settings/form_settings_EditFederation.php";
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4 text-center" id="pswWarning"></div>
		<div class="col-md-4"></div>
	</div>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4 text-center"><h4>Változtatások jóváhagyása</h4></div>
		<div class="col-md-4"></div>
	</div>
	<div class="row form-group">
		<div class="col-md-3"></div>
		<div class="col-md-3 text-right">Jelszó</div>
		<div class="col-md-3"><input type="password" class="form-control" name="UserPwd" id="UserPwd"></div>
		<div class="col-md-3"></div>
	</div>
	<div class="row">
		<div class="col-md-4"></div>
		<div class="col-md-4"><input type="submit" value="Jóváhagyás" id="settingsSubmit" class="btn btn-success btn-block"></div>
		<div class="col-md-4"></div>
	</div>
</form>
<script>
	var form_config = {button: null};
	$("#settingsSubmit").click(function(){
		form_config.button = 'submit1';
	});
	$("#settingsForm").keypress(function(e){
		if (e.which==13){
			form_config.button = 'submit1';
		}
	});


	$("#createClub").click(function(){
		form_config.button = null;
	});
	$("#createFed").click(function(){
		form_config.button = null;
	});
	$("#settingsForm").submit(function(e){
		if (form_config.button != null){
			e.preventDefault();
			var password = $("input[name='UserPwd']").val();
			var data = $(this).serializeArray();
			if(password.length>0){
				$("#pswWarning").html('<img src="css/ajax-loader.gif"/> Frissítés...');
				$.ajax({
					url: 'Model/model_ajax_updateSettings.php',
					type: 'POST',
					data: $(this).serialize(),
					dataType: 'text'
				}).done(function(data){
					if(data=="1"){
						$("#pswWarning").html('<div class="alert alert-danger text-center">Rossz a jelszó</div>');
					}
					else if(data =="2"){
						location.reload();
					}
					else if (data == "3"){
						$("#pswWarning").html('<div class="alert alert-warning text-center">Hiányzó adatok</div>');
					}
					else if (data == "4"){
						$("#pswWarning").html('<div class="alert alert-warning text-center">Hiba történt a adatok frissítésével</div>');
					}
					else{
						console.log(data);
						$("#pswWarning").html('<div class="alert alert-warning text-center">Hiba történt a adatok frissítésével</div>');
					}



				}).fail(function(){
					alert('Ajax Submit Failed ...');
				});
			}
			else {
				$("#pswWarning").html('<div class="alert alert-warning text-center">Nem adtt meg biztonsági jelszót</div>');
			}
		}
	})
</script>