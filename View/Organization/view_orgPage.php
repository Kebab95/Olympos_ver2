<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4"><h1><?php echo $orgTitle?></h1></div>
	<div class="col-md-4"></div>
</div>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4"><span class="counter pull-right"></span></div>
	<div class="col-md-4"><input type="text" class="search form-control" placeholder="mit keresel?"></div>
</div>
<div class="row">
	<div class="col-md-12">
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
						echo "<td id='textVerticalAlign'><a onclick='showModalProfile(".UserTasks::getUser()->getId().",".$item["UserId"].")'>
														".$item["UserName"]."</a></td>";
						echo "<td class='text-center'><input type='button' onclick='showModalOrg(".UserTasks::getUser()->getId().",".$item["orgId"].")' class='btn btn-info btn-block' value='Adatok'></td>";
						if($item["member"]){
							echo "<td id='textVerticalAlign' class='text-center'>Tagja</td>";
						}
						else {
							if($_GET["nav"]=="fed"){
								echo "<td class='text-center'>
								<input type='button' name='orgJoinSubmit' ".(UserTasks::isClubLeader()?"":"disabled")." class='btn btn-success' value='Csatlakozás' data-toggle='modal' data-target='#myModal".$modalNum."'>";
								include 'View/Organization/view_modalJoinOrg.php';
								$modalNum++;
								echo "</td>";
							}
							else {
								echo "<td class='text-center'>
								<input type='button' name='orgJoinSubmit' class='btn btn-success' value='Csatlakozás' data-toggle='modal' data-target='#myModal".$modalNum."'>";
								include 'View/Organization/view_modalJoinOrg.php';
								$modalNum++;
								echo "</td>";
							}

						}


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
	</div>
</div>


