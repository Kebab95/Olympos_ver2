<?php
$siteTitle = "Olympos";
$navBarTitle = "Olympos";
$footerText = "Olymposról";

$navBarItems = array();

if(UserTasks::isLoggedUser()){

	UserTasks::refreshUser();

	$navBarItems["Organization"] =array(
			"href" =>"?nav=fed",
			"title" =>"Szövetségek"
	);
	$navBarItems["Club"] =array(
			"href" =>"?nav=club",
			"title" =>"Egyesületek"
	);
	$navBarItems["Comp"] = array(
			"href" =>"?contest=list",
			"title" =>"Versenyek"

	);

	//echo json_encode($navBarItems);
	$obj = UserTasks::getUser();
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
	if(UserTasks::isClubLeader() || UserTasks::isMember()){
		$userDropbox["Clubdata"] = array(
				"href" =>"?nav=myclub",
				"title" =>"Szövetségi Tagság"
		);
	}
	if(UserTasks::isAdmin()){
		$userDropbox["Users"]=array("href"=>"#","title" =>"Users");
	    //array_push($userDropbox["Users"],array("href"=>"#","title" =>"Users"));
	}
	if(UserTasks::isVisitor()){
		$userDropbox["Inbox"] = array("href"=>"#","title"=>"Inbox");
	    //array_push($userDropbox,array("href"=>"#","title"=>"Inbox"));
	}
	$userLogout = array("title"=>"Kijelentkezés");
}
else{
	$userName = 'Belépés';
	$userDropbox ="View/Login/form_Login.php";
}
$navBarItems["About"] = array(
		"href" =>"?nav=about",
		"title" =>"Rólunk"
);