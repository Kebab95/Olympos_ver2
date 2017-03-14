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
		self::init();
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
	public static function isFederationMember(){
		self::init();
		return self::$User->isFedMember();
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
	public static function getDivision_toString($divisionNum){
		switch($divisionNum){
			case 1: return "A";
			case 2: return "B";
			case 3: return "C";
			case 4: return "D";
			case 5: return "F";
			default: return "Hiba";
		}
	}
	public static function getDivisionArray(){
		return array(1=>"A",2=>"B",3=>"C",4=>"D",5=>"F");
	}
}