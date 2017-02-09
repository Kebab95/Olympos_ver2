<?php

class PostalAdd
{
	private $pcode,$town,$street;

	/**
	 * PostalAdd constructor.
	 * @param $pcode
	 * @param $street
	 * @param $town
	 */
	public function __construct($pcode, $street, $town)
	{
		$this->pcode = $pcode;
		$this->street = $street;
		$this->town = $town;
	}

	/**
	 * @return mixed
	 */
	public function getPcode()
	{
		return $this->pcode;
	}

	/**
	 * @param mixed $pcode
	 */
	public function setPcode($pcode)
	{
		$this->pcode = $pcode;
	}

	/**
	 * @return mixed
	 */
	public function getTown()
	{
		return $this->town;
	}

	/**
	 * @param mixed $town
	 */
	public function setTown($town)
	{
		$this->town = $town;
	}

	/**
	 * @return mixed
	 */
	public function getStreet()
	{
		return $this->street;
	}

	/**
	 * @param mixed $street
	 */
	public function setStreet($street)
	{
		$this->street = $street;
	}

	public function __toString()
	{
		return $this->pcode." ".$this->town.", ".$this->street;
	}


}