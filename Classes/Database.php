<?php
class Database
{
	private $dbHost;
	private $dbUser;
	private $dbPsw;
	private $dbName;
	private $dbConnection;
	private $connection;
	private $encoding;

	public function __construct($dbHost,$dbUser,$dbPsw,$dbName = "", $encoding = "utf8"){
		$this->encoding = $encoding;
		$this->dbHost = $dbHost;
		$this->dbName = $dbName;
		$this->dbUser = $dbUser;
		$this->dbPsw = $dbPsw;
		$this->connection = false;
	}
	public function __destruct (){
		$this->ConnClose();
	}

	public function Connect($dbName = NULL){
		if (is_null($dbName)){
			$dbName = $this->dbName;
		}
		$this->dbConnection = pg_connect("host=".$this->dbHost." port=5432 dbname=".$this->dbName." user=".$this->dbUser." password=".$this->dbPsw." options='--client_encoding=".$this->encoding."'")or die('connection failed');
		//$this->dbConnection = new pg_connect($this->dbHost,$this->dbUser,$this->dbPsw,$dbName);
		if ( !$this->dbConnection){
			$this->connection = false;
			return "Connection error.";
		} else {
			$this->connection = true;
			//mysqli_set_charset($this->dbConnection, $this->encoding);
			return true;
		}

	}
	public function ConnClose(){
		if($this->connection){
			pg_close($this->dbConnection);
			$this->connection = false;
			return true;
		} else{
			return false;
		}
	}
	public function isConnected(){
		return $this->connection;
	}
	public function getConnection(){
		return $this->dbConnection;
	}

	// Change the required dbName whenever you want
	public function setDbName($dbName){
		if($this->isConnected()){
			$this->ConnClose();
		}
		$this->dbName = $dbName;
	}

	// General SQL function if you want custome querys.
	public function sql($operation, $newDb = false){
		//echo $operation."<br>";
		/*
		if ($newDb){
			$this->Connect("");
		} else {
			$this->Connect();
		}
		*/

		if ($this->connection){
			$result = pg_query($operation);
			//$this->ConnClose();
			return $result;
		} else {
			return "Connection error!";
		}

	}
	public function sqlWithConn($sql){
		$this->Connect();
		$back = $this->sql($sql);
		$this->ConnClose();
		return $back;
	}
	public function selectGetResult($tableName, $columns, $where,$innerjoin=null, $etc = ""){
		$this->Connect();
		$back = $this->sql("SELECT ".$columns." FROM " . $tableName .($innerjoin !=null?" ".$innerjoin:"").($where !=null?" WHERE " . $where . " ":"")  . $etc . ";");
		$this->ConnClose();
		return $back;
	}
	public function select($tableName, $columns, $where,$innerjoin=null, $etc = ""){
		$this->Connect();
		$back = $this->sql("SELECT ".$columns." FROM " . $tableName .($innerjoin !=null?" ".$innerjoin:"").($where !=null?" WHERE " . $where . " ":"")  . $etc . ";");
		$this->ConnClose();
		$row = pg_fetch_row($back, NULL, PGSQL_ASSOC);
		return $row;
	}
	protected function returnInsertQuery($tableName, $columns, $values, $etc = ""){
		return "INSERT INTO ".$tableName.(strcmp($columns,'*')==0?"":" ( ".$columns." ) ")." VALUES ( ".$values." ) ".$etc;
	}
	public function insert($tableName, $columns, $values, $etc = ""){
		$this->Connect();
		$back = $this->sql(self::returnInsertQuery($tableName,$columns,$values,$etc).";");
		$this->ConnClose();
		return $back;
	}
	public function returnUpdateQuery($tableName, $values, $where, $etc = ""){
		return "UPDATE ".$tableName." SET ".$values." WHERE ".$where." ".$etc.";";
	}
	public function update($tableName, $values, $where, $etc = ""){
		$this->Connect();
		$back = $this->sql("UPDATE ".$tableName." SET ".$values." WHERE ".$where." ".$etc.";");
		$this->ConnClose();
		return $back;
	}
	public function returnFunctionSelect($function){
		return "SELECT ".$function;
	}
}