<?php
foreach ($orgValue as $item) {
	/** @var Organization $fed */
	$fed = $item["org"];
	$clubArray = $item["members"];
	?>
	<div class="panel panel-default">
		<div class="panel-heading"><?php echo $fed->getName()?></div>
		<div class="panel-body">
			<div class="row center-block text-center">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<label>Szövetség képviselő neve:</label>
					<a onclick="showModalProfile(<?php echo UserTasks::getUser()->getId()?>,<?php echo $fed->getLeaderID()?>)"><?php echo DBLoad::loadUserWithoutActive($fed->getLeaderID())->getName()?></a>
				</div>
				<div class="col-md-4">
				</div>
			</div>

			<div class="row center-block text-center">
				<div class="col-md-4"></div>
				<div class="col-md-4">
					<input onclick="showModalOrg(<?php echo UserTasks::getUser()->getId().",".$fed->getId()?>)" type="button" class="btn btn-default" value="További Adatok">
				</div>
				<div class="col-md-4"></div>
			</div>


		</div>
		<div class="row">
			<div class="col-xs-12 table-responsive">
				<table class="table table-striped table-hover table-bordered ">
					<thead>
					<tr>
						<th>Egyesület Neve</th>
						<th>Egyesület vezetője</th>
						<th></th>
						<?php echo ($isLeader?"<th></th>":"")?>
						<?php echo ($isLeader?"<th></th>":"")?>

					</tr>
					</thead>
					<tbody>
					<?php
					if(is_array($item["members"])) {
						/** @var Organization $member */
						foreach ($item["members"] as $member) {
							echo "<tr>";
							echo "<td>".$member->getName()."</td>";
							echo "<td>".DBLoad::loadUserWithoutActive($member->getLeaderID())->getName()."</td>";
							echo "<td><button type='button' onclick='showModalOrg(".UserTasks::getUser()->getId().",".$member->getId().")' class='btn btn-info btn-block'>Profil</button> </td>";
							if($isLeader){
							    echo "<td></td>";
							    echo "<td></td>";
							}
							echo "</tr>";
							/*
							$User = $member["memberUser"];
							echo "<tr ".($member["memberCurrent"]?"class='info'":"")." id='clubMemberRow".$User->getId()."'>";
							echo "<td>".$User->getName()."</td>";
							if(SportUser::isSportUser($User)){
								echo "<td>".$User->getWeight()."</td>";
								echo "<td>".$User->getBeltGrades()."</td>";

							}
							else {
								echo "<td colspan='2'>Nincsenek sport adatai ennek a felhasználónak</td>";
							}
							echo "<td>".$User->getAge()."</td>";
							if($isLeader){
								echo "<td><button onclick='sportDataUpdate(".$User->getId().")' class='btn btn-info2 btn-block'>Sport Adatok Frissítése</button></td>";
							}


							if($User->getEmail()!=null){
								echo "<td><button class='btn btn-info btn-block' onclick='showModalProfile(".UserTasks::getUser()->getId().",".$User->getId().")'>Profil</button> </td>";
							}
							else {
								if($isLeader){
									echo "<td><input type='button' class='btn btn-info btn-block' value='Létrehozás'></td>";
								}
								else {
									echo "<td>Nem regisztrált Felhasználó</td>";
								}

							}


							if($isLeader){
								echo "<td><button class='btn btn-danger btn-block'>Tag törlése</button> </td>";
							}
							echo "</tr>";
							*/
							/*
							echo "<tr ".($member["memberCurrent"]?"class='info'":"").">";
							echo "<td>" . $User->getName() . "</td>";
							echo "<td>" . ($User->getTelefon()!=null?$User->getTelefon():"<div class='center-block text-center'>
										<label>Ennek a profilnak nincsenek egyéb adataia</label>
										</div>") . "</td>";
							echo "<td>".($User->getTelefon()!=null?"<a href='?profile=".$User->getId()."'>Tovább a profilhoz</a>":"<input type='button' class='btn btn-info' value='Létrehozás'>")."</td>";
							echo ($isLeader?"<td><button class='btn btn-danger'>Tag törlése</button> </td>":"");
							echo "</tr>";
							*/
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
		</div>

	</div>
	<hr>
	<div id="sportDataUpdateDiv"></div>
	<?php
}