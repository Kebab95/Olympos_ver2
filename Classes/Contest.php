<?php
class Contest implements DBClass
{
	private $orgID;
	private $id,$name,$locale,$entryFee,$description,$date;
	private $localeID;
	private $entry;
	private $closed;
	private $dataChecks;


	/**
	 * Contest constructor.
	 * @param $id
	 * @param $name
	 * @param $locale
	 * @param $entryFee
	 * @param $description
	 * @param $date
	 */
	public function __construct($orgID,
	                            $id,
	                            $name,
	                            PostalAdd $localeID,
	                            $entryFee,
	                            $description,
	                            $date,
	                            bool $isEntry,
	                            bool $closed,
	                            bool $DataCheck)
	{
		$this->orgID= $orgID;
		$this->id = $id;
		$this->name = $name;
		$this->locale = $localeID;
		$this->entryFee = $entryFee;
		$this->description = $description;
		$this->date = $date;
		$this->entry = $isEntry;
		$this->closed = $closed;
		$this->dataChecks = $DataCheck;
	}

	public static function createWithDB(array $data)
	{
		$intance = new self(
			$data[DBData::$contestOrgID],
			$data[DBData::$contestID],
			$data[DBData::$contestName],
			new PostalAdd($data[DBData::$postalAddPCode],$data[DBData::$postalAddTown],$data[DBData::$postalAddStreet]),
			$data[DBData::$contestEntryFee],
			$data[DBData::$contestDesc],
			$data[DBData::$contestDate],
				($data[DBData::$contestIsEntry]=="t"),
				($data[DBData::$contestClosed]=="t"),
				($data[DBData::$contestDataChecks]=="t"));
		return $intance;
	}

	/**
	 * @return mixed
	 */
	public function getId()
	{
		return $this->id;
	}

	/**
	 * @return mixed
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @return mixed
	 */
	public function getLocale()
	{
		return $this->locale;
	}

	/**
	 * @return mixed
	 */
	public function getEntryFee()
	{
		return $this->entryFee;
	}

	/**
	 * @return mixed
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * @return mixed
	 */
	public function getDate()
	{
		return $this->date;
	}

	/**
	 * @return mixed
	 */
	public function getOrgID()
	{
		return $this->orgID;
	}

	/**
	 * @return mixed
	 */
	public function getLocaleID()
	{
		return $this->localeID;
	}

	/**
	 * @return bool
	 */
	public function getIsEntry()
	{
		return $this->entry;
	}

	/**
	 * @return bool
	 */
	public function isClosed()
	{
		return $this->closed;
	}

	/**
	 * @return bool
	 */
	public function isDataChecks()
	{
		return $this->dataChecks;
	}






}
