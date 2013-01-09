<?php
class SO_Helper implements IF_BASE_NAMED_OBJECT{

	private static $personModel;
	private static $dateModel;

	private $person;
	private $children;

	public function __construct(IF_BASE_NAMED_OBJECT $person){
		$this->person = $person;
	}

	public static function setPersonModel($model){
		self::$personModel = $model;
	}

	public static function setDatesModel($model){
		self::$dateModel = $model;
	}

	public function getName() {
		return $this->person->getName();
	}

	public function getID(){
		return $this->person->getID();
	}

	public function getType(){
		return BASE_OBJECT_TYPE_HELPER;
	}

	public function getFirstName(){
		return $this->person->getFirstName();
	}
	
	public function getLastName(){
		return $this->person->getLastName();
	}
	
	public function getBirthday(){
		return $this->person->getBirthday();
	}
	
	public function getChildren(){
		if (! isset($this->children)){
			$this->children = self::$personModel->getChildrenByHelper($this);
		}
		return $this->children;
	}

	public function getDates(DateTime $beginDate = null, DateTime $endDate = null){
		$children = $this->getChildren();
		$returnDates = array();
		foreach ($children as $child){
			$returnDates = array_merge($returnDates, self::$dateModel->getDatesByChild($child, $beginDate, $endDate, $this));
		}
		return $returnDates;
	}

	public function getOpenDates(DateTime $beginDate = null, DateTime $endDate = null){
		$children = $this->getChildren();
		if($endDate == null){
			$endDate = new DateTime();
			$endDate->setDate(2015, 12, 31);
		}
		$returnDates = array();
		foreach ($children as $child) {
			if($endDate != null){
				$returnDates = array_merge($returnDates, self::$dateModel->getOpenDatesByChild($child, null, $beginDate, $endDate));
			}
		}
		return $returnDates;
	}
}