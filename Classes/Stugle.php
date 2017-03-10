<?php
class Stugle implements DBClass
{
	private $Racer1,$Racer2;
	private $Racer1Point,$Racer2Point;
	private $winner;
	private $Racer1OutcomeId,$Racer2OutcomeId;
	private $cccID;

	/**
	 * Stugle constructor.
	 * @param $Racer1
	 * @param $Racer2
	 * @param $Racer1Point
	 * @param $Racer2Point
	 * @param $winner
	 * @param $Racer1OutcomeId
	 * @param $Racer2OutcomeId
	 * @param $cccID
	 */
	public function __construct($Racer1, $Racer2, $Racer1Point, $Racer2Point, $winner, $Racer1OutcomeId, $Racer2OutcomeId, $cccID)
	{
		$this->Racer1 = $Racer1;
		$this->Racer2 = $Racer2;
		$this->Racer1Point = $Racer1Point;
		$this->Racer2Point = $Racer2Point;
		$this->winner = $winner;
		$this->Racer1OutcomeId = $Racer1OutcomeId;
		$this->Racer2OutcomeId = $Racer2OutcomeId;
		$this->cccID = $cccID;
	}
	public function asd(){
		return new Stugle(null,null,null,null,null,null,null,null);
	}
	public function compareTo(Stugle $data){

	}


	public static function createWithDB(array $data)
	{
		// TODO: Implement createWithDB() method.
	}
}