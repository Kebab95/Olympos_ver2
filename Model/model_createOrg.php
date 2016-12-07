<?php
if($orgType == "Club"){
	$_SESSION["orgType"]="Egyesület";
}
elseif($orgType=="Fed"){
	$_SESSION["orgType"] ="Szövetség";
}