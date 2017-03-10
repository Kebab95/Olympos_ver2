<?php
if(isset($login) && $login){
    ?>
	<div class="alert alert-success text-center" id="welcomeTex">
		Sikeres belépés.
	</div>
	<?php
}
?>
<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading">
				Felhasználó: <?php echo $adminName?> <span class="glyphicon glyphicon-triangle-right"></span> Verseny neve: <a href="?contestview=<?php echo $contestID?>"><?php echo $contestName?></a>
			</div>
			<div class="panel-body">
				<select class="form-control" id="adminCompSelect">
					<option value=""></option>
					<?php
					/** @var Competetion $comp */
					foreach ($compArray as $comp) {
						echo "<option value='".$comp->getId()."'>".$comp->getTitle()."</option>";
					}
					?>
				</select>
			</div>
		</div>
	</div>
	<div class="col-md-2"></div>
</div>
<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<div id="catTable"></div>
	</div>
	<div class="col-md-2"></div>
</div>
<script>
	$("#adminCompSelect").change(function(e){
		$.ajax({
			url:'Model/contestView/adminLog/model_ajax_loadCompCats.php',
			type: 'POST',
			data: {
				compID: $(this).val(),
				adminID: <?php echo $adminID?>
			},
			dataType: 'html'
		}).done(function(data){
			console.log(data);
			$("#catTable").html(data);

		}).fail(function(){
			alert("Hiba!");
		});
	});
	$(document).ready(function(){
		setTimeout(function(){
			$("#welcomeTex").fadeOut(500,function(){
				$(this).html("");
			})

		},2000);


	});
</script>