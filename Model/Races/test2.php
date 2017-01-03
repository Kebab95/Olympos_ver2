<?php
include "../../includeClasses.php";
$DBTasks = new DBTasks();
$a = json_decode($_POST["createRaceHidden"],true);
$b = json_decode(json_encode($_POST),true);
echo $DBTasks->createRace($a,$b);