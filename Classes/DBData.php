<?php
class DBData
{
	private static $dataSchema="data";

	private static $mainUserTable ="main_user";
	private static $emailDataTable ="email_data";
	private static $telefonDataTable ="telefon_data";
	private static $userTypeTable ="user_type";
	private static $permissionTable="permission";
	private static $organizationTable="org_data";
	//Schema nevek

	public static  function getDataSchema(){
		return self::$dataSchema;
	}

	//Tábla nevek

	public static function getMainUserTable(){
		return self::getDataSchema().".".self::$mainUserTable;
	}
	public static function getEmailDataTable(){
		return self::getDataSchema().".".self::$emailDataTable;
	}
	public static function getTelefonDataTable(){
		return self::getDataSchema().".".self::$telefonDataTable;
	}
	public static function getUserTypeTable(){
		return self::getDataSchema().".".self::$userTypeTable;
	}
	public static function getPermissionTable(){
		return self::getDataSchema().".".self::$permissionTable;
	}
	public static function getOrganizationTable(){
		return self::getDataSchema().".".self::$organizationTable;
	}

	//Main User tábla oszlop nevei

	static $mainUserID ="mu_id";
	static $mainUserType ="mu_type";
	static $mainUserEmailID ="mu_email_id";
	static $mainUserTelefonID ="mu_telefon_id";
	static $mainUserName ="mu_name";
	static $mainUserPass ="mu_pass";
	static $mainUserActive="mu_active";
	/*tatic $mainUserActive ="mu_active";
	static $mainUserCreateTime ="mu_ctime";
	static $mainUserLastChangeTime ="mu_lctime";*/

	//Email Data tabla oszlop nevei
	static $emailDataID ="ed_id";
	static $emailDataAdd="ed_add";

	//Telefon Data tábla oszlop nevei
	static $telefonDataID ="td_id";
	static $telefonDataNum="td_num";

	//Permission tábla oszlop nevei
	static $permissionMainUserID ="p_mu_id";
	static $permissionAdmin = "p_admin";
	static $permissionModerator="p_moderator";
	static $permissionVisitor="p_visitor";
	static $permissionFedLeader="p_federation_leader";
	static $permissionClubLeader="p_club_leader";
	static $permissionJudge="p_judge";
	static $permissionTrainer="p_trainer";
	static $permissionMember="p_member";

	//Organization tábla oszlop nevei
	static $orgID="";
	static $orgMainUserID="";
	static $orgShortName="";
	static $orgRegNum="";
	static $orgPostalAddID="";
	static $orgFaxNumID="";
	static $orgWebsite="";
	static $orgTaxNumID="";
}