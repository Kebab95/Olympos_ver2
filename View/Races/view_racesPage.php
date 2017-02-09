<?php
if($haveContest){
    ?>
	<div class="panel panel-info">
		<div class="panel-heading">
			Saját versenyek
		</div>
		<table class="table table-striped table-hover table-bordered">
			<thead>
			<tr>
				<th>Verseny Neve</th>
				<th>Dátuma</th>
				<th>Helyszíne</th>
				<th>Szervező</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<?php
				if(count($contestVal)>0){
					foreach ($contestVal as $item) {
						echo "<tr>";
						echo "<td>".$item[DBData::$contestName]."</td>";
						echo "<td>".$item[DBData::$contestDate]."</td>";
						echo "<td>".$item[DBData::$contestLocaleID]."</td>";
						echo "<td>".$item[DBData::$mainUserName]."</td>";
						echo "<td><a href='?contestview=".$item[DBData::$contestID]."'> <button class='btn btn-default'>Megtekintés</button> </a></td>";
						echo "</tr>";
					}
				}
				else {
					echo "<tr><td colspan='3'>Nincs verseny, Hiba!</td></tr>";
				}
			?>
			</tbody>
		</table>
	</div>
	<hr>
	<?php
}
?>
<div class="row">
	<div class="col-xs-4"></div>
	<div class="col-xs-4">
		<a href="?contest=create"><button class="btn btn-default btn-block">Verseny készítése</button> </a>
	</div>
	<div class="col-xs-4"></div>
	<div class="col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				Versenyek
			</div>
			<table class="table table-striped table-hover table-bordered">
				<thead>
				<tr>
					<th>Verseny Neve</th>
					<th>Dátuma</th>
					<th>Helyszíne</th>
					<th>Szervező</th>
					<th></th>
				</tr>
				</thead>
				<tbody>
				<?php
				if(count($otherContest)>0){
					foreach ($otherContest as $item) {
						echo "<tr>";
						echo "<td>".$item[DBData::$contestName]."</td>";
						echo "<td>".$item[DBData::$contestDate]."</td>";
						echo "<td>".$item[DBData::$contestLocaleID]."</td>";
						echo "<td>".$item[DBData::$mainUserName]."</td>";
						echo "<td><a href='?contestview=".$item[DBData::$contestID]."'> <button class='btn btn-default'>Megtekintés</button> </a></td>";
						echo "</tr>";
					}
				}
				else {
					echo "<tr><td colspan='5' class='text-center'>Nincsenek versenyek</td></tr>";
				}
				?>
				</tbody>
			</table>
		</div>
	</div>
</div>
