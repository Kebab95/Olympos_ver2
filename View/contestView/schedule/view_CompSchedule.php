<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4 text-center">
		<select class="form-control" id="scheduleSelect" onchange="changeSelectList(this)">
			<option value=""></option>
			<?php
			/** @var Competetion $comp */
			foreach ($CompArray as $comp) {
				echo "<option value='".$comp->getId()."'>".$comp->getTitle()."</option>";
			}
			?>
		</select>
	</div>
	<div class="col-md-4">

	</div>
</div>

<script>
	function changeSelectList(select){
		var selectVal = $(select).val();
		if(selectVal!=""){
			$.ajax({
				url:'Model/contestView/schedule/model_ajax_compTable.php',
				type: 'POST',
				data: {contestID:<?php echo $_GET["contestview"]?>,compID:selectVal,
					userID:<?php echo UserTasks::getUser()->getId() ?>},
				dataType:'html'
			}).done(function(data){
				//console.log(data);
				$("#compTable").html(data);
			}).fail(function(){
				alert("Hiba!");
			});
		}
		else{
			alert("Nem választott ki versenyszámot");
		}
	}
</script>
<div id="compTable"></div>