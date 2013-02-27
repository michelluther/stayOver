<?php

class SO_Child implements IF_BASE_NAMED_OBJECT, IF_SO_Child, IF_SO_Person {
	
	private static $personModel;
	
	private $person;
	private $helpers;
	private $parents;
	
	public static function setPersonModel($model){
		self::$personModel = $model;
	}
	
	public function __construct($person){
		$this->person = $person;
	}
	
	public function getID(){
		return $this->person->getID();
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
	
	public function getBirthday(){
		return $this->person->getBirthday();
	}
	
	public function getGender(){
		return $this->person->getGender();
	}

	public function getType(){
		return BASE_OBJECT_TYPE_CHILD;
	}
	
	public function getHelpers(){
		if(!isset($this->helpers)){
			$this->helpers = self::$personModel->getHelpersByChild($this);
		}
		return $this->helpers;
	}
	
	public function getParents(){
		if(!isset($this->parents)){
			$this->parents = self::$personModel->getParentsByChild($this);
		}
		return $this->parents;
	}
	
	public function setFirstName($firstName){
		$this->person->setFirstName($firstName);
	}
	
	public function setLastName($lastName){
		$this->person->setLastName($lastName);
	}
	
	public function setBirthday(DateTime $birthday){
		$this->person->setBirthday($birthday);
	}
	
}