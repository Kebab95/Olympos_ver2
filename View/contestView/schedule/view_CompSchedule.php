<div class="row">
	<div class="col-md-4"></div>
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
	<div class="col-md-4"></div>
</div>
<div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-3"><button class="btn btn-default btn-block" id="scheduleList">Lista</button></div>
	<div class="col-md-3"><button class="btn btn-info2 btn-block">Nyomtatás</button> </div>
	<div class="col-md-3"></div>
</div>
<script>
	$("#scheduleList").click(function(){
		var selectVal = $("#scheduleSelect").val();
		if(selectVal!=""){
			$.ajax({
				url:'Model/contestView/schedule/model_ajax_compTable.php',
				type: 'POST',
				data: {compID:selectVal},
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
</script>
<div id="compTable"></div>