<div class="alert alert-warning text-center">
	<?php
	if(isset($_GET["nav"]) && $_GET["nav"] ==405){
		echo "<h3>405-s hiba</h3>";
	}
	else{
		echo "<h3>404-es hiba</h3>";
	}
	?>
	<h3>Az oldal nem található</h3>
</div>