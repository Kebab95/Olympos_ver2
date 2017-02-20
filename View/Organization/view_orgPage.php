<div class="container text-center">
	<h1><?php echo $orgTitle?></h1>
</div>
<div class="container">
<div class="form-group pull-right">
	<input type="text" class="search form-control" placeholder="What you looking for?">
</div>
<span class="counter pull-right"></span>
</div>
	<div class="table-responsive">
	<table class="table table-striped table-hover table-bordered results">
		<thead>
		<tr>
			<th><?php echo $orgName?> Neve</th>
			<th>Telefon száma</th>
			<th>Képviselő neve</th>
			<th></th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		<?php
		if(is_array($all)){
			/** @var Organization $item */
			$modalNum=0;
			foreach ($orgList as $key => $item) {
				echo "<tr>";
				echo "<td id='textVerticalAlign'>".$item["Name"]."</td>";
				echo "<td id='textVerticalAlign'>".$item["Telefon"]."</td>";
				echo "<td id='textVerticalAlign'><a href='?profile=".$item["UserId"]."'>".$item["UserName"]."</td>";
				echo "<td class='text-center'><a><input type='button' class='btn btn-default' value='Adatok'></a></td>";
				echo "<td class='text-center'>
								<input type='button' name='orgJoinSubmit' class='btn btn-success' value='Csatlakozás' data-toggle='modal' data-target='#myModal".$modalNum."'>";
				include 'View/Organization/view_modalJoinOrg.php';
				$modalNum++;
				echo "</td>";
				echo "</tr>";
			}
		}
		else {
			echo "<tr>
				<td colspan='3' class='text-center'>".$all."</td>
</tr>";
		}

		?>
		</tbody>
	</table>
		</div>
<?php
if(count($pagination)>0){
 ?>
	<ul class="pagination">
		<?php
		foreach ($pagination as $key => $item) {
			echo "<li><a href=\"".($item)."\">".($key)."</a></li>";
		}
		?>
	</ul>

	<?php
}
?>

