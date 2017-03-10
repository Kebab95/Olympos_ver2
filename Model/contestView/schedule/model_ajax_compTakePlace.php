<?php
include "../../../includeClasses.php";
$DBTasks = new DBTasks();
$DBTasks->Connect();
$DBTasks->sql('UPDATE '.DBData::getConnectionCCCTable().'
SET '.DBData::$connCCC_TakePlace."=true,ccc_lctime=now()".'
FROM contest.assignment
WHERE contest.assignment.a_ccc_id = contest.contest_comp.ccc_id AND '.DBData::$connCCC_CompID."=".$_POST["compID"]);
$DBTasks->ConnClose();
//$DBTasks->update(,,,"FROM contest.assignment WHERE ");
