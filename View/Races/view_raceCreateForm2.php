<script type="application/javascript">
	var myvar = <?php echo $valami; ?>;
	console.log(myvar);


	// Get the modal
	var modal = document.getElementById('myModal');

	// Get the button that opens the modal
	var btn = document.getElementById("newCompType");

	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];

	// When the user clicks on the button, open the modal
	btn.onclick = function() {
		e.preventDefault(e);
		modal.style.display = "block";
	}

	// When the user clicks on <span> (x), close the modal
	span.onclick = function() {
		modal.style.display = "none";
	}

	// When the user clicks anywhere outside of the modal, close it
	window.onclick = function(event) {
		if (event.target == modal) {
			modal.style.display = "none";
		}
	}
</script>
<form method="post" id="raceForm2">
	<h3 class="text-center">Verseny szám Létrehozása / Beállítása <br> <small>Maximum 10 varsenyszám hozható létre</small></h3>
	<script src="Model/Races/fieldNameScript.js"></script>
	<div class="input_fields_wrap">
	</div>
	<hr>
	<button class="btn btn-success center-block add_field_button">Új Verseny szám hozzáadása</button>
	<hr>


	<div class="form-group row text-center">
		<input type="submit" class="btn btn-success" value="Verseny számok elkészítése" name="createRace2" id="createRace2">
	</div>

	<input type="hidden" id="compNumber" name="compNumber" value="1">
</form>
<style>
	.modal {
		display: none; /* Hidden by default */
		position: fixed; /* Stay in place */
		z-index: 1; /* Sit on top */
		left: 0;
		top: 0;
		width: 100%; /* Full width */
		height: 100%; /* Full height */
		overflow: auto; /* Enable scroll if needed */
		background-color: rgb(0,0,0); /* Fallback color */
		background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}

	/* Modal Content/Box */
	.modal-content {
		background-color: #fefefe;
		margin: 15% auto; /* 15% from the top and centered */
		padding: 20px;
		border: 1px solid #888;
		width: 80%; /* Could be more or less, depending on screen size */
	}

	/* The Close Button */
	.close {
		color: #aaa;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}

	.close:hover,
	.close:focus {
		color: black;
		text-decoration: none;
		cursor: pointer;
	}
</style>
<div id="myModal" class="modal">

	<!-- Modal content -->
	<div class="modal-content">
		<span class="close">&times;</span>
		<p>Some text in the Modal..</p>
	</div>

</div>
