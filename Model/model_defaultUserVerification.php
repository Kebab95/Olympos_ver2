<?php
$siteTitle = "Olympos";
$navBarTitle = "Olympos";
$footerText = "Olymposról";

$navBarItems = array(
		"Organization" => array(
				"href" =>"?nav=fed",
				"title" =>"Szövetségek"
		),
		"Club" => array(
				"href" =>"?nav=club",
				"title" =>"Egyesületek"
		)
);
/** @var $obj User */
if(Tasks::isLoggedUser()){
	$obj = $_SESSION["User"];
	$_SESSION["User"] = $DBTasks->loadUser($obj->getId());
	$userName = $obj->getName();



	$userDropbox = array(
		"Profle" => array(
			"href"=>"?profile=".$obj->getId(),
			"title"=>"Profil"
		),
		"Settings" => array(
			"href"=>"?nav=settings",
			"title"=>"Beállítás"
		)
	);
	if($obj->isAdmin()){
	    array_push($userDropbox["Users"],array("href"=>"#","title" =>"Users"));
	}
	if($obj->isVisitor()){
		$userDropbox["Inbox"] = array("href"=>"#","title"=>"Inbox");
	    //array_push($userDropbox,array("href"=>"#","title"=>"Inbox"));
	}
	$userLogout = array("title"=>"Kijelentkezés");
}
else{
	$userName = 'Belépés';
	$userDropbox ="View/Login/form_login.php";
}