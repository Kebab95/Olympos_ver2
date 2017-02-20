<?php

class CompTypes implements DBClass
{
	private $id,$name,$mu_id;


	private $events;

	/**
	 * CompTypes constructor.
	 * @param $id
	 * @param $name
	 * @param $mu_id
	 * @param $events
	 */
	public function __construct($id, $name, $mu_id, array $events)
	{
		$this->id = $id;
		$this->name = $name;
		$this->mu_id = $mu_id;
		$this->events = $events;
	}

	public static function createWithDB(array $data)
	{
		$event = DBData::getCompTypesFlagArray();
		$temp = array();
		foreach ($event as $item) {
			$temp[$item] = $data[$item];
		}
		return new self($data[DBData::$compTypesID],
						$data[DBData::$compTypesName],
						$data[DBData::$compTypesMUid],
						$temp);
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
	public function getMuId()
	{
		return $this->mu_id;
	}

	/**
	 * @return bool
	 */
	public function getEvents($eventName)
	{
		if(isset($this->events[$eventName])){
			return ($this->events[$eventName]=="t");
		}
		else {
			return null;
		}
	}

	function __toString()
	{
		return $this->getName()."";
	}

}