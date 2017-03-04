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
	public static function getMemberDataInsertUpdateFunction(array $var){

	}
	public static function getInsertCategory(array $var){
		return self::getContestSchema()."insertcategory(
					".$var[self::$compCatID].",
					".$var[self::$compCatSex].",
					".$var[self::$ageGrpMin].",
					".$var[self::$ageGrpMax].",
					'".$var[self::$personalGrpTitle]."',
					".$var[self::$compCatFed_cost1].",
					".$var[self::$compCatFed_cost2].",
					".$var[self::$compCatnonFed_cost1].",
					".$var[self::$compCatnonFed_cost2].",
					".$var[self::$compCatForeign_cost1].",
					".$var[self::$compCatForeign_cost2].",

		)";
	}

	public static function getCompTypesFlagArray(){
		return self::getCompTypesFlag(-1);
	}
	public static function getCompTypesFlag($index){
		$array = array(
				"comp_types_fighting_event",
				"comp_types_technical_event"
		);
		if($index>=0 && count($array) >$index){
			return $array[$index];
		}
		else {
			return $array;
		}
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
	private static $compCategory ="comp_category";
	private static $ageGrp="age_group";
	private static $personalgrp="personal_group";

	private static $memberdata="member_data";
	private static $beltGradesData="belt_grades_data";
	private static $entry = "entry";
	private static $knowLedge = "knowledge_level";
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
	public static function getMemberDataTable(){
		return self::getDataSchema().".".self::$memberdata;
	}
	public static function getBeltGradesDataTable(){
		return self::getDataSchema().".".self::$beltGradesData;
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
	public static function getCompCategoryTable(){
		return self::getContestSchema().".".self::$compCategory;
	}
	public static function getAgeGroupTable(){
		return self::getContestSchema().".".self::$ageGrp;
	}
	public static function getPersonalGroupTable(){
		return self::getContestSchema().".".self::$personalgrp;
	}
	public static function getEntryTable(){
		return self::getContestSchema().".".self::$entry;
	}
	public static function getKnowLedgeTable(){
		return self::getDataSchema().".".self::$knowLedge;
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
	static $mainUserCreateTime ="mu_ctime";
	static $mainUserLastChangeTime ="mu_lctime";
	static $mainUserSex = "mu_sex";

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
	static $contestID="contest_id";
	static $contestOrgID="contest_org_id";
	static $contestLocaleID="locale";
	static $contestDate="date2";
	static $contestEntryFee="entry_fee";
	static $contestName="contest_name";
	static $contestDesc="contest_description";
	static $contestDelete="delete";
	static $contestIsEntry="is_entry";
	static $contestClosed="contest_closed";
	static $contestDataChecks="contest_datachecks";

	//Contest Comp Types oszlopok
	static $contestCompTypesID ="comp_types_id";
	static $contestCompTypesName ="comp_types_name";
	static $contestCompTypesMuID ="comp_types_mu_id";

	//Competetions oszlop nevek
	static $competetionsID ="comp_id";
	static $competetionsTitle ="comp_title";
	static $competetionsTypeID="type_id";
	static $competetionsSex ="sex";
	static $competetionsMuID="mu_id";

	// Connectnion CCC oszlop nevei
	static $connCCC_Id="ccc_id";
	static $connCCC_ContestID ="ccc_contest_id";
	static $connCCC_CompID ="ccc_comp_id";
	static $connCCC_CatID="ccc_cat_id";
	static $connCCC_Delete="ccc_delete";

	//comp types oszlop nevei
	static $compTypesID ="comp_types_id";
	static $compTypesName="comp_types_name";
	static $compTypesMUid="comp_types_mu_id";

	//Comp category oszlop nevei
	static $compCatID="compcat_id";
	static $compCatOrgID="compcat_org_id";
	static $compCatAgeGrpID="age_grp_id";
	static $compCatPersonalGrpID="personal_grp_id";
	static $compCatFed_cost1="fed_cost1";
	static $compCatFed_cost2="fed_cost2";
	static $compCatnonFed_cost1="nonfed_cost1";
	static $compCatnonFed_cost2="nonfed_cost2";
	static $compCatForeign_cost1="foreign_cost1";
	static $compCatForeign_cost2="foreign_cost2";
	static $compCatSex="sex";
	static $compCatSexWoman="sexWoman";
	static $compCatSexMan="sexMan";
	static $compCatSexMixed="sexMixed";
	static $compCatGroupFight="groupFight";

	//Age grp oszlop nevei
	static $ageGrpID="age_grp_id";
	static $ageGrpCompID="age_grp_comp_id";
	static $ageGrpMin="min";
	static $ageGrpMax="max";
	static $ageGrpTypeID="age_grp_comp_type_id";
	static $ageGrpDelete="age_grp_delete";

	//Personal grp oszlop nevei
	static $personalGrpID="personal_id";
	static $personalGrpCompID="personal_comp_id";
	static $personalGrpTitle="personal_title";
	static $personalGrpTypeID="personal_comp_types_id";
	static $personalGrpDelete="personal_delete";
	static $personalGrpWeightMin = "personal_weightmin";
	static $personalGrpWeightMax = "personal_weightmax";
	static $personalGrpknowLEdgeID="personal_knowledge_id";

	//Member data oszlop
	static $memberDataID="md_id";
	static $memberDataMuID="md_muid";
	static $memberDataWeight="md_weight";
	static $memberDataGradesBeltID="md_beltgradesid";
	static $memberDataLastChangeTime="md_lctime";

	//Belt grades oszlop nevek
	static $beltGradesID="bgd_id";
	static $beltGradesName="bgd_name";
	static $beltGradesWeight="bgd_weight";
	static $beltGradesLevelId="bgd_klevel_id";

	//Entry oszlop nevek
	static $entryID ="en_id";
	static $entryMuID ="en_muid";
	static $entryorgID="en_orgid";
	static $entryCompID="en_compid";
	static $entryContestID="en_contest";
	static $entryActive="en_active";
	static $entryPaid="en_paid";
	static $entryDeliberation="en_deliberation";
	static $entryReleased="en_released";

	//KnowLedge table oszlop nevek
	static $knowLedgeId="klevel_id";
	static $knowLedgeName="klevel_name";

}