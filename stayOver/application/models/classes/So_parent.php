<?php

include_once 'So_person.php';

class SO_Parent implements IF_BASE_NAMED_OBJECT, IF_SO_Person, IF_SO_Parent, IF_BASE_SAVEABLE{

	// Model is injected
	protected static $model;

	private $person;
	private $children = array();		// SO_Person

	public static function setPersonModel($model){
		self::$model = $model;
	}

	public function __construct(IF_BASE_NAMED_OBJECT &$person){
		$this->person = $person;
	}

	public function addChild(SO_Person $child){
		$changesMade = false;
		if (!isset($this->children[$child->getID()])){
			$changesMade = self::$model->addParentToChildAssignment($this, $child);
			$children[$child->getID()] = new SO_Child($child);
		}
		return $changesMade;
	}

	public function removeChild(SO_Child $child){
		$changesMade = false;
		if (isset($this->children[$child->getID()])){
			$changesMade = self::$model->removeParentToChildAssignment($this, $child);
			if($changesMade){
				unset($this->children[$child->getID()]);
			}
		}
		return $changesMade;
	}

	public function getChildren(){
		if(!($this->children)){
			$this->children = self::$model->getChildrenByParent($this);
		}
		return $this->children;
	}

	public function getChild($id){
		$children = $this->getChildren();
		return $children[$id];
	}

	public function assignHelperToChild(IF_BASE_NAMED_OBJECT $child, IF_BASE_NAMED_OBJECT $helper){
		$changesMade = self::$model->addHelperToChildAssignment($child, $helper);
	}

	public function unassignHelperFromChild(IF_BASE_NAMED_OBJECT $child, IF_BASE_NAMED_OBJECT $helper){
		$changesMade = self::$model->removeHelperToChildAssignment($child, $helper);
	}

	public function getDates(DateTime $beginDate = null, DateTime $endDate = null){
		$children = $this->getChildren();
		$returnArray = array();
		foreach ($children as $child) {
			$childDates = SO_DateFactory::getDatesByChild($child, $beginDate, $endDate);
			$returnArray = array_merge($childDates, $returnArray);
		}
		ksort($returnArray);
		return $returnArray;
	}


	// IF_BASE_NAMED_PERSON
	public function getID(){
		return $this->person->getID();
	}

	public function getType() {
		return $this->person->getType();
		;
	}

	public function getName(){
		return $this->person->getName();
	}

	public function getFirstName(){
		return $this->person->getFirstName();
	}

	public function getLastName(){
		return $this->person->getLastName();
	}

	public function getGender(){
		return $this->person->getGender();
	}
	
	public function getBirthday(){
		return $this->person->getBirthday();
	}

	public function getEmail(){
		return $this->person->getEmail();
	}
	// IF_BASE_SAVEABLE
	public function save(){

	}
}