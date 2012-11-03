<?php

class SO_Child implements IF_BASE_NAMED_OBJECT, IF_SO_Child {
	
	private static $personModel;
	
	private $person;
	private $helpers;
	
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

	public function getType(){
		return BASE_OBJECT_TYPE_CHILD;
	}
	
	public function getPerson(){
		return $this->person;
	}
	
	public function getHelpers(){
		if(!isset($helpers)){
			$this->helpers = self::$personModel->getHelpersByChild($this);
		}
		return $this->helpers;
	}
	
}