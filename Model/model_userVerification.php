<?php
/** @var $obj User */
if(isset($_SESSION["User"])){
	$obj = $_SESSION["User"];
	$user = $obj->getName();
	$userDropbox = array(
		"Profle" => array(
			"href"=>"?profile=".$obj->getId(),
			"title"=>"Profile"
		),
		"Settings" => array(
			"href"=>"#",
			"title"=>"Settings"
		)
	);
	if($obj->isAdmin()){
	    array_push($userDropbox["Users"],array("href"=>"#","title" =>"Users"));
	}
	if($obj->isVisitor()){
		$userDropbox["Inbox"] = array("href"=>"#","title"=>"Inbox");
	    //array_push($userDropbox,array("href"=>"#","title"=>"Inbox"));
	}
}
else{
	$user = 'Belépés';
	$userDropbox ="View/Login/form_login.php";
}