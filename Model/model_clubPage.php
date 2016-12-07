<?php
$orgTitle = "Egyesületek";
$pagination = array("#","#","#","#");
if(Tasks::isLoggedUser()){
	$listClass ="col-md-9";
	/** @var User $obj */
	$obj = $_SESSION["User"];
	$userLeader = $obj->isFederationLeader();

	if(!$userLeader){
		$dontMemberOrg = "Nem tartozik egy Eggyesülethez sem<br>Létrehozhat egy újjat vagy csatlakozhat egy meglévő Egyesüllethez";
	}
	else{

	}
}
else {
	$listClass ="col-md-12";
}