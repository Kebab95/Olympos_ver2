<?php
//$userArray
//$outComeTypeArray
$circleResult = $DBTasks->sqlWithConn('SELECT s_circle FROM contest_data.strugle_data WHERE s_ccc_id='.$cccID.' ORDER BY s_circle DESC LIMIT 1');
$circleRow =pg_fetch_row($circleResult, NULL, PGSQL_ASSOC);
$circle = null;
if(isset($circleRow["s_circle"])){
	$circle = intval($circleRow["s_circle"]);
}
else {
	$circle = 1;
}
?>
<div class="row">
	<div class="col-md-12 text-center">
		<?php echo $circle?>. Kör
	</div>
</div>
<div class="row">
	<?php
		if((count($userArray)%2)!=0){

		}
		else {
			/** @var SportUser $user */
			foreach ($userArray as $user) {
				?>
				<div class="col-md"
				<?php
			}
		}
	?>
</div>
<?php