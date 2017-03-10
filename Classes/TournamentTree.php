<?php

class TournamentTree
{
	private $Strugle;
	private $jobb;
	private $bal;

	public function __construct()
	{

	}
	public function Ures(){
		return $this->Strugle==null;
	}
	public function beilleszt(Stugle $data){
		if($this->Ures()){
			$this->Strugle = $data;
			$bal = new TournamentTree();
			$jobb = new TournamentTree();
		}
		else {

		}
	}

}