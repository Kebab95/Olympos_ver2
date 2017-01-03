<script src="Model/Races/race.js"></script>
<div class="panel panel-default center-block asd" >
	<div class="panel-heading">
		Verseny létrehozása
	</div>
	<div class="panel-body" id="raceCreateBody">
		<form method="post" id="raceForm1">
			<div class="form-group row" >
				<label class="col-sm-4 col-form-label">Verseny neve</label>
				<div class="col-sm-8">
					<input type="text" class="col-sm-8 form-control" required name="<?php echo $raceName?>" placeholder="Név">
				</div>

			</div>
			<div class="form-group row" >
				<label class="col-sm-4 col-form-label" for="sel1">Házigazda szervezet:</label>
				<div class="col-sm-8">
					<select class="form-control" required name="<?php echo $raceOrgID?>" id="sel1">
						<?php
						foreach ($select as $index => $item) {
							echo "<option value='".$item."'>".$index."</option>";
						}
						?>
					</select>
				</div>


			</div>
			<div class="form-group row">
				<label class="control-label col-md-12" for="date">Leírása</label>
				<textarea class="form-control" name="<?php echo $raceDesc?>"></textarea>
			</div>
			<hr>
			<div class="form-group row">
				<label class="col-md-12 control-label">Helyszín</label>
				<div class="form-group col-md-12">
					<label class="col-lg-3 col-form-label">Irányítószám</label>
					<div class="col-lg-3"><input type="number" min="1111" max="9999" name="<?php echo $racePCode?>" value="<?php echo (isset($_SESSION["orgPCode"])? $_SESSION["orgPCode"]: "");?>" required class="form-control"></div>
					<label class="col-lg-2 col-form-label">Település</label>
					<div class="col-lg-4"><input type="text" name="<?php echo $raceTown?>" value="<?php echo (isset($_SESSION["orgPTown"])? $_SESSION["orgPTown"]: "");?>" required class="form-control"></div>
				</div>
				<div class="form-group col-md-12">
					<label class="col-sm-4 col-form-label">Utca, házszám</label>
					<div class="col-sm-8"><input type="text" name="<?php echo $raceStreet?>" value="<?php echo (isset($_SESSION["orgPStreet"])? $_SESSION["orgPStreet"]: "");?>" required class="form-control"></div>
				</div>


			</div>
			<hr>
			<div class="form-group row">
				<label class="control-label col-md-12" for="date">Időpont</label>
				<div class="col-xs-12">
					<input class="form-control" type="datetime-local" required name="<?php echo $raceDate?>"  id="example-datetime-local-input">
				</div>
			</div>
			<hr>
			<div class="form-group row">
				<label class="control-label col-md-6" for="date">Nevezési díj</label>
				<div class="input-group col-md-6">
					<span class="input-group-addon">HUF</span>
					<input type="number" name="<?php echo $raceFee?>" class="form-control">
				</div>

			</div>



			<div class="form-group row text-center">
				<input type="submit" class="btn btn-success" value="Tovább" name="createRace1" id="createRace1">
			</div>
		</form>

	</div>
</div>

