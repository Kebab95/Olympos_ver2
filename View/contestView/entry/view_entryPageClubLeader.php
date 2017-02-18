<?php
/** @var Organization $ClubOrg */
/** @var User $clubMember */
?>
<div class="row">
	<div class="col-md-2"></div>
	<div class="col-md-8">
		<div class="panel panel-default">
			<div class="panel-heading text-center">
				<h3>Nevezés</h3>
				<h4><?php echo $contestName?></h4>
				<h5><?php echo $ClubOrg->getName()?></h5>
			</div>
			<div class="panel-body">

			</div>
			<table class="table table-bordered table-responsive">
				<thead>
					<td>Név</td>
					<td></td>
				</thead>
				<tbody>
					<?php
					foreach ($ClubMembers as $clubMember) {
						echo "<tr>";
						echo "<td>".$clubMember->getName()."</td>";
						echo "<td><label>Ki választ</label>
								<input type='checkbox'></td>";
						echo "</tr>";
					}
					?>
				</tbody>
			</table>
			<div class="panel-footer">
				<a href="?contestview=<?php echo $contestID?>"><button class="btn btn-info btn-block">Mégse</button></a>
			</div>
		</div>
	</div>
	<div class="col-md-2"></div>
</div>