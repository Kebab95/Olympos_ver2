<?php
include "../../../includeClasses.php";
DBLoad::init();
if($_POST["type"] == DBData::getCompTypesFlag(0)){
	$leaderBoard = DBLoad::loadFightLeaderboard($_POST["cccID"]);
}
else if($_POST["type"]==DBData::getCompTypesFlag(1)){
	$leaderBoard = DBLoad::loadTechnicalLeaderboard($_POST["cccID"]);
}
if($leaderBoard!=null){
	?>
	<div class='modal fade' id='leaderBoardModal'>
		<div class="modal-dialog <?php echo $_POST["type"] == DBData::getCompTypesFlag(0)?"modal-sm":"" ?>">
			<div class="modal-content">
				<div class="modal-header">
					Helyezések
				</div>
				<div class="modal-body">
					<?php
					if($_POST["type"] == DBData::getCompTypesFlag(0)){
						foreach ($leaderBoard as $value) {
							?>
							<div class="row">
								<div class="col-xs-6 text-right"><?php echo $value["rated"]?>. Helyezet</div>
								<div class="col-xs-6"><?php echo $value["user_name"]?></div>

							</div>
							<?php
						}
					}
					else if($_POST["type"]==DBData::getCompTypesFlag(1)){
						foreach ($leaderBoard as $value) {
							?>
							<div class="row">
								<div class="col-xs-4 text-right"><?php echo $value["rated"]?>. Helyezet</div>
								<div class="col-xs-4 text-center"><?php echo $value["user_name"]?></div>
								<div class="col-xs-4"><?php echo $value["user_point"]?> Pont</div>
							</div>
							<?php
						}
					}

					?>



				</div>
				<div class="modal-footer">
					<div class="row">
						<div class="col-md-4"></div>
						<div class="col-md-4">
							<button type="button" class="btn btn-danger btn-block" id='leaderboardModalClose'>Close</button>
						</div>
						<div class="col-md-4"></div>
					</div>

				</div>
			</div>
		</div>
	</div>
	<?php
}
else {
	echo "<div class='modal fade' id='profileModal'>";
	echo "<div class='modal-dialog'>";
	echo "<div class='modal-content'>";
	echo "<div class='modal-header'>";
	echo "Profil";
	echo "</div>";
	echo "<div class='modal-body'>";
	echo "<div class=\"row center-block text-center\">
	<div class=\"col-xs-12 col-md-12 alert alert-warning\">
		<strong>Hiba!</strong> Nem létező felhasználó!
	</div>
</div>";
	echo "</div>";
	echo "<div class='modal-footer'>";
	echo "<button type=\"button\" class=\"btn btn-default\" id='leaderboardModalClose'>Close</button>";
	echo "</div>";
	echo "</div>";
	echo "</div>";

}