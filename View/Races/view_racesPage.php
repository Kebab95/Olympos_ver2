<?php
if($haveContest){
    ?>
	<div class="panel panel-default">
		<div class="panel-heading">
			Saját versenyek
		</div>
		<div class="panel-body">
			<?php echo $name ?>
		</div>
	</div>
	<?php
}
?>


<a href="?race=create"><button class="btn btn-default">Verseny készítése</button> </a>