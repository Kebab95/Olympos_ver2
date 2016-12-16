<?php
foreach ($orgValue as $item) {
	?>
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo $item["orgName"]?></div>
		<div class="panel-body">
			<div class="row regInputs center-block text-center">
				<div>
					<label>Egyesület képviselő neve:</label>
					<a href="?profile=<?php echo $item["orgLeaderID"]?>"><?php echo $item["orgLeader"]?></a>
				</div>
				<div>
					<input type="button" class="btn btn-default" value="További Adatok">
				</div>
			</div>

		</div>
		<table class="table table-striped table-hover table-bordered">
			<thead>
			<tr>
				<th>Tag Neve</th>
				<th>Telefon</th>
				<th></th>
				<th></th>

			</tr>
			</thead>
			<tbody>
			<?php
			if(is_array($item["members"])) {
				foreach ($item["members"] as $member) {
					echo "<tr ".($member["memberCurrent"]?"class='info'":"").">";
					echo "<td>" . $member["memberName"] . "</td>";
					echo "<td>" . $member["memberTelefon"] . "</td>";
					echo "<td><a href='?profile=".$member["memberId"]."'>Tovább a profilhoz</a></td>";
					echo "<td><button class='btn btn-danger'>Tag törlése</button> </td>";
					echo "</tr>";
				}
			}
			else {
				echo "<tr>
									<td colspan='3' class='text-center'>Hiba vagy nincs tag</td>
									</tr>";
			}
			?>
			</tbody>
		</table>
	</div>

	<?php
}
?>

