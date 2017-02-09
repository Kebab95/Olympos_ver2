<?php
class UserTasks
{
	/** @var $User User */
	private static $User;
	private static function init(){
		if(isset($_SESSION["User"])){
			self::$User = $_SESSION["User"];
		}
		else{
			self::$User = null;
		}

	}

	public static function getUser(){
		return self::$User;
	}
	public static function isMember(){
		self::init();
		return self::$User->isMember();
	}
	public static function isAdmin(){
		self::init();
		return self::$User->isAdmin();
	}
	public static function isVisitor(){
		self::init();
		return self::$User->isVisitor();
	}
	public static function isFederationLeader(){
		self::init();
		return self::$User->isFederationLeader();
	}
	public static function isClubLeader(){
		self::init();
		return self::$User->isClubLeader();
	}
	public static function isLoggedUser(){
		self::init();
		return (self::$User!=null);
	}
	public static function refreshUser(){
		/** @var User $obj */
		$obj = $_SESSION["User"];
		$_SESSION["User"] = DBLoad::loadUser($obj->getId());
	}
}