<div class="row form-group">
	<div class="col-md-4 text-center">
		<div class="checkbox" >
			<input type="checkbox" checked id="justClosed"> Csak a lezártakat mutassa
		</div>
	</div>
	<div class="col-md-4 text-center">
		<select class="form-control" id="scheduleSelect">
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
		<div id="counter"></div>
	</div>
</div>
<div id="compTable"></div>
<script>
	$("#scheduleSelect").change(function(e){
		var selectVal = $(this).val();
		if(selectVal!=""){
			$("#compTable").html('<div class="row"><div class="col-md-4"></div><div class="col-md-4 text-center center-block"><img src="css/ajax-loader.gif"> Betöltés...</div><div class="col-md-4"></div></div> ');
			$.ajax({
				url:'Model/contestView/closed/model_ajax_closedCompTable.php',
				type: 'POST',
				data: {contestID:<?php echo $_GET["contestview"]?>,compID:selectVal,
					userID:<?php echo UserTasks::getUser()->getId() ?>,
					justClosed: $('#justClosed').is(':checked')},
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
	});
	$("#justClosed").change(function(){
		var selectVal = $("#scheduleSelect").val();
		if(selectVal!=""){
			$("#compTable").html('<div class="row"><div class="col-md-4"></div><div class="col-md-4 text-center center-block"><img src="css/ajax-loader.gif"> Betöltés...</div><div class="col-md-4"></div></div> ');
			$.ajax({
				url:'Model/contestView/closed/model_ajax_closedCompTable.php',
				type: 'POST',
				data: {contestID:<?php echo $_GET["contestview"]?>,compID:selectVal,
					userID:<?php echo UserTasks::getUser()->getId() ?>,
					justClosed: $(this).is(':checked')},
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
	});
	function changeSelectList(select){
		var selectVal = $(select).val();
		if(selectVal!=""){
			$("#compTable").html('<div class="row"><div class="col-md-4"></div><div class="col-md-4 text-center center-block"><img src="css/ajax-loader.gif"> Betöltés...</div><div class="col-md-4"></div></div> ');
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