<?php

class SO_Person extends SO_JSONData implements IF_BASE_NAMED_OBJECT {
	// Model is injected
	protected static $model;

	protected $id;
	protected $name;
	protected $firstName;
	protected $lastName;

	public function __construct($id = null){
		if($id != null){
			$this->id = $id;
		}
	}

	public static function setPersonModel($model){
		self::$model = $model;
	}
	//IF_BASE_NAMED_OBJECT
	public function getID(){
		return $this->id;
	}
	
	public function getType(){
		return BASE_OBJECT_TYPE_PERSON;
	}
	
	public function getName(){
		return $this->firstName . ' ' . $this->lastName;
	}
	
	public function getFirstName(){
		return $this->firstName;
	}
	
	public function setFirstName($firstName){
		$this->firstName = $firstName;
	}
	
	public function setLastName($lastName){
		$this->lastName = $lastName;
	}
	public function init(){
		if(isset($this->id)){
			self::$model->getPersonData($this);
		} else {
			throw new Exception("No ID set, so cannot initialize");
		}
	}

}