<?php
include "../../includeClasses.php";
session_start();

$_POST[DBData::$raceDate] = date('Y-m-d H:i:s',strtotime($_POST[DBData::$raceDate]));
echo json_encode($_POST);
