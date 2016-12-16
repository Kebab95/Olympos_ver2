<?php

include "../includeClasses.php";
session_start();
/** @var $obj User */
if(Tasks::isLoggedUser()){
	$obj = $_SESSION["User"];
	$_SESSION["User"] = DBLoad::loadUser($obj->getId());
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
else {
	$userName = 'Belépés';
	$userDropbox ="../View/Login/form_login.php";
}
//include '../Model/model_defaultUserVerification.php'

?>
<ul class="nav navbar-nav  navbar-right">
	<li class="dropdown" id="navBar-dropdown">

		<ul class="dropdown-menu">

			<?php
			if(is_array($userDropbox)) {
				foreach ($userDropbox as $key => $item) {
					echo '<li><a href='.$item['href'].'><i class="fa"></i> '.$item['title'].'</a></li>';
				}
				?>
				<li class="divider"></li>
				<li><form action="" method="post"><input type="submit" name="logout" class="btn btn-danger center-block" value="<?php echo $userLogout["title"]?>"></form></li>
				<!--<li><a href="?nav=logout"><i class="fa fa-power-off"></i> Log Out</a></li>!--><?php
			}
			else {
				include $userDropbox;
			}
			?>
		</ul>

	</li>
</ul>