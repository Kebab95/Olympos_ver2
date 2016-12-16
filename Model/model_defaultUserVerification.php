<?php
$siteTitle = "Olympos";
$navBarTitle = "Olympos";
$footerText = "Olymposról";

$navBarItems = array();
/** @var $obj User */
if(Tasks::isLoggedUser()){
	$obj = $_SESSION["User"];
	$_SESSION["User"] = DBLoad::loadUser($obj->getId());
	$navBarItems["Organization"] =array(
			"href" =>"?nav=fed",
			"title" =>"Szövetségek"
	);
	$navBarItems["Club"] =array(
			"href" =>"?nav=club",
			"title" =>"Egyesületek"
	);
	$navBarItems["Comp"] = array(
		"href" =>"?nav=races",
		"title" =>"Versenyek"

	);
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
	if($obj->isClubLeader() || $obj->isMember()){
		$userDropbox["Clubdata"] = array(
				"href" =>"?nav=myclub",
				"title" =>"Szövetségi Tagság"
		);
	}
	if($obj->isAdmin()){
		$userDropbox["Users"]=array("href"=>"#","title" =>"Users");
	    //array_push($userDropbox["Users"],array("href"=>"#","title" =>"Users"));
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
$navBarItems["About"] = array(
		"href" =>"?nav=about",
		"title" =>"Rólunk"
);