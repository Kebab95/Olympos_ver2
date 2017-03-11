<?php

$leaderboardRes = $DBTasks->sqlWithConn('Select
  *
From
  contest_data.technical_strugle_data
Where
  contest_data.technical_strugle_data.ts_ccc_id = '.$cccID.' And
  contest_data.technical_strugle_data.ts_use = True
Order By
  contest_data.technical_strugle_data.ts_racer_point Desc');

$i = 1;
$valami = "";
while($lead =pg_fetch_row($leaderboardRes, NULL, PGSQL_ASSOC)){
	$user = DBLoad::loadUserWithoutActive($lead["ts_racer_id"]);
	if($back){
		$valami.='<div class="row">';
			$valami.='<div class="col-xs-4">'.$i.'. Helyezet</div>';
			$valami.='<div class="col-xs-6">'.$user->getName().'</div>';
			$valami.='<div class="col-xs-2">'.$lead["ts_racer_point"].' Pont</div>';
		$valami.='</div>';
	}
	else {
		?>
		<div class="row">
			<div class="col-xs-4"><?php echo $i?>. Helyezet</div>
			<div class="col-xs-6"><?php echo $user->getName()?></div>
			<div class="col-xs-2"><?php echo $lead["ts_racer_point"]?> Pont</div>
		</div>
		<?php
	}

	$i++;
}

