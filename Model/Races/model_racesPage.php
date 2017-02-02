<?php
$contest = DBLoad::loadLeaderContests($_SESSION["User"]->getId());
$haveContest = (count($contest)>0);
if($haveContest){
	$name = $contest[2][1];
}
else {

}

$asd = "Hello";