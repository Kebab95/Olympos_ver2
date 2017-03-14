<?php
if(isset($error) && $error){
    echo "<h3>Hiba a létrehozásnál</h3>";
}
?>
<form method="post" id="raceForm1" action="">
	<div class="form-group row" >
		<label class="col-sm-4 col-form-label">Verseny neve</label>
		<div class="col-sm-8">
			<input type="text" class="col-sm-8 form-control" value="<?php echo (isset($values[$raceName])?$values[$raceName]:"")?>" name="<?php echo $raceName?>" placeholder="Név">
		</div>

	</div>
	<div class="form-group row" >
		<label class="col-sm-4 col-form-label" for="sel1">Házigazda szervezet:</label>
		<div class="col-sm-8">
			<select class="form-control" required name="<?php echo $raceOrgID?>" id="sel1">
				<?php
				foreach ($select as $index => $item) {
					$option ="<option";
					if($item ==$values[$raceOrgID] && isset($values[$raceOrgID])){
						$option.=" selected ";
					}
					$option.=" value='".$item."'>".$index."</option>";
					echo $option;
				}
				?>
			</select>
		</div>


	</div>
	<div class="form-group row">
		<label class="control-label col-md-12" for="date">Leírása</label>
		<textarea class="form-control"  name="<?php echo $raceDesc?>"><?php echo (isset($values[$raceDesc])?$values[$raceDesc]:"")?></textarea>
	</div>
	<hr>
	<div class="form-group row">
		<label class="col-md-12 control-label">Helyszín</label>
		<div class="form-group col-md-12">
			<label class="col-lg-3 col-form-label">Irányítószám</label>
			<div class="col-lg-3"><input type="number" min="1111" max="9999"  name="<?php echo $racePCode?>" value="<?php echo (isset($values[$racePCode])?$values[$racePCode]:"")?>" required class="form-control"></div>
			<label class="col-lg-2 col-form-label">Település</label>
			<div class="col-lg-4"><input type="text" name="<?php echo $raceTown?>" value="<?php echo (isset($values[$raceTown])?$values[$raceTown]:"")?>" required class="form-control"></div>
		</div>
		<div class="form-group col-md-12">
			<label class="col-sm-4 col-form-label">Utca, házszám</label>
			<div class="col-sm-8"><input type="text" name="<?php echo $raceStreet?>" value="<?php echo (isset($values[$raceStreet])?$values[$raceStreet]:"")?>" required class="form-control"></div>
		</div>


	</div>
	<hr>
	<div class="form-group row">
		<label class="control-label col-md-12" for="date">Időpont</label>
		<div class="col-xs-12">
			<input class="form-control" type="text"  value="<?php echo (isset($values[$raceDate])?$values[$raceDate]:"")?>" required name="<?php echo $raceDate?>"  id="datetimepicker">
		</div>
	</div>
	<hr>
	<div class="form-group row">
		<label class="control-label col-md-6" for="date">Alap Nevezési díj</label>
		<div class="input-group col-md-6">
			<span class="input-group-addon">HUF</span>
			<input type="number" name="<?php echo $raceFee?>" value="<?php echo (isset($values[$raceFee])?$values[$raceFee]:"")?>" class="form-control">
		</div>

	</div>



	<div class="form-group row text-center">
		<input type="submit" class="btn btn-success" value="Verseny létrehozása" name="createRace1" id="createRace1">
	</div>
</form>
<script>
	$(function () {
		$('#datetimepicker').datetimepicker({
			locale: 'ru'
		});
	});

</script>