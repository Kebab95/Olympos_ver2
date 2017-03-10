<?php
include "../../../includeClasses.php";
$DBTasks = new DBTasks();
$seqRes = $DBTasks->sqlWithConn('SELECT a_seq FROM contest.assignment
WHERE a_ccc_id='.$_POST["newCCCId"].' Order By
  contest.assignment.a_seq Desc LIMIT 1');
$seq = pg_fetch_row($seqRes, NULL, PGSQL_ASSOC);
$DBTasks->sqlWithConn('UPDATE contest.assignment
						SET a_ccc_id='.$_POST["newCCCId"].',
						a_lctime=NOW(),
						a_seq='.(intval($seq["a_seq"])+1).'
WHERE a_ccc_id='.$_POST["defaultCCCId"]);