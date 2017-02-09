<?php
class DBData
{
	//Function neve

	public static function getEmailFunction($var){
		return self::getDataSchema().".\"emailExistFoo\"('".$var."')";
	}
	public static function getTelefonFunction($var){
		return self::getDataSchema().".\"telefonExistFoo\"('".$var."')";
	}
	public static function getCreateContestFunction(array $var){
		return self::getContestSchema().".\"createContest\"(
					'".$var[self::$contestName]."',
					'".$var[self::$contestDate]."',
					".$var[self::$contestEntryFee].",
					'".$var[self::$contestDesc]."',
					'".$var[self::$postalAddPCode]."',
					'".$var[self::$postalAddTown]."',
					'".$var[self::$postalAddStreet]."',
					".$var[self::$contestOrgID]."
		)";
	}


	private static $dataSchema="data";
	private static $orgSchema ="org";
	private static $contestSchema="contest";
	private static $compSchema="competitions";

	private static $mainUserTable ="main_user";
	private static $mainUserSeq = "main_user_seq";
	private static $emailDataTable ="email_data";
	private static $telefonDataTable ="telefon_data";
	private static $userTypeTable ="user_type";
	private static $permissionTable="permission";
	private static $postalAddDataTable ="postal_address_data";
	private static $organizationTable="org_data";

	private static $clubMemberHistoryTable ="club_mship_history";
	private static $clubLeaderTable ="club_leader";
	private static $fedLeaderTable="federation_leader";

	private static $contestTable="contest";
	private static $contestCompTypes ="comp_types";
	private static $competetions ="competetions";
	private static $connectionCCC = "contest_comp";
	//Schema nevek

	public static  function getDataSchema(){
		return self::$dataSchema;
	}
	public static  function getOrgSchema(){
		return self::$orgSchema;
	}
	public static function getContestSchema(){
		return self::$contestSchema;
	}
	public static function getCompSchema(){
		return self::$compSchema;
	}

	//Tábla nevek

	public static function getMainUserTable(){
		return self::getDataSchema().".".self::$mainUserTable;
	}
	public static function getMainUserSeq(){
		return self::getDataSchema().".".self::$mainUserSeq;
	}
	public static function getPostalAddDataTable(){
		return self::getDataSchema().".".self::$postalAddDataTable;
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
		return self::getOrgSchema().".".self::$organizationTable;
	}

	public static function getClubMemberHistoryTable(){
		return self::getOrgSchema().".".self::$clubMemberHistoryTable;
	}
	public static function getClubLeaderTable(){
		return self::getOrgSchema().".".self::$clubLeaderTable;
	}
	public static function getFedLeaderTable(){
		return self::getOrgSchema().".".self::$fedLeaderTable;
	}
	public static function getContestTable(){
		return self::getContestSchema().".".self::$contestTable;
	}
	public static function getContestCompTypesTable(){
		return self::getContestSchema().".".self::$contestCompTypes;
	}
	public static function getCompetetionsTable(){
		return self::getContestSchema().".".self::$competetions;
	}
	public static function getConnectionCCCTable(){
		return self::getContestSchema().".".self::$connectionCCC;
	}
	//Main User tábla oszlop nevei

	static $mainUserID ="mu_id";
	static $mainUserType ="mu_type";
	static $mainUserEmailID ="mu_email_id";
	static $mainUserTelefonID ="mu_telefon_id";
	static $mainUserName ="mu_name";
	static $mainUserPass ="mu_pass";
	static $mainUserActive="mu_active";
	static $mainUserBDate = "mu_bdate";
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
	static $orgID="org_id";
	static $orgMainUserID="org_mu_id";
	static $orgShortName="org_shor_name";
	static $orgRegNum="org_reg_num";
	static $orgPostalAddID="org_postal_add_id";
	static $orgFaxNumID="org_fax_id";
	static $orgWebsite="org_website";
	static $orgTitle="org_title";
	static $orgTaxNum="org_taxnum";

	//Club member history tábla oszlop nevei
	static $chID="ch_id";
	static $chClubID="ch_club_id";
	static $chMemberID="ch_member_id";
	static $chCurrent="ch_current";
	static $chCTime="ch_ctime";
	static $chLCTime="ch_lctime";

	//Postal Address data tábla poszlop nevei
	static $postalAddID="pad_id";
	static $postalAddPCode ="pad_pcode";
	static $postalAddTown="pad_town";
	static $postalAddStreet="pad_street";

	//Fed leader table oszlop nevei
	static $fedLeaderID ="fl_id";
	static $fedLeaderFEDID ="fl_fed_id";
	static $fedLeaderMUID ="fl_mu_id";

	//Org leader table oszlop nevei
	static $clubLeaderID ="cl_id";
	static $clubLeaderCLUBID="cl_club_id";
	static $clubLeaderMUID ="cl_mu_id";

	//Contest table oszlop nevei
	static $contestID="id";
	static $contestOrgID="org_id";
	static $contestLocaleID="locale";
	static $contestDate="date2";
	static $contestEntryFee="entry_fee";
	static $contestName="name";
	static $contestDesc="description";
	static $contestDelete="delete";
	static $contestIsEntry="is_entry";

	//Contest Comp Types oszlopok
	static $contestCompTypesID ="id";
	static $contestCompTypesName ="name";
	static $contestCompTypesMuID ="mu_id";

	//Competetions oszlop nevek
	static $competetionsID ="id";
	static $competetionsTitle ="title";
	static $competetionsTypeID="type_id";
	static $competetionsSex ="sex";
	static $competetionsMuID="mu_id";

	// Connectnion CCC oszlop nevei
	static $connCCC_ContestID ="contest_id";
	static $connCCC_CompID ="comp_id";
	static $connCCC_CatID="cat_id";

	//comp types oszlop nevei
	static $compTypesID ="id";
	static $compTypesName="name";
	static $compTypesMUid="mu_id";
}