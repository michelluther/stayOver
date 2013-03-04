<?php

class SO_Person extends SO_JSONData implements IF_BASE_NAMED_OBJECT, IF_BASE_SAVEABLE {
	// Model is injected
	protected static $model;

	protected $id;
	protected $name;
	protected $firstName;
	protected $lastName;
	protected $email;
	protected $birthday;

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
	
	// IF_BASE_SAVEABLE
	public function save(){
		if(isset($this->id)){
			return self::$model->updatePersonalData($this);
		} else {
			$this->id = self::$model->insertPerson($this);
			if($this->id != null){
				return true;
			}
		}
	}
	
	public function getFirstName(){
		return $this->firstName;
	}
	
	public function getLastName(){
		return $this->lastName;
	}
	
	public function getBirthday(){
		return $this->birthday;
	}
	
	public function getGender(){
		return IF_SO_Person::genderMale;
	}
	
	public function setFirstName($firstName){
		$this->firstName = $firstName;
	}
	
	public function setLastName($lastName){
		$this->lastName = $lastName;
	}
	
	public function setBirthday(DateTime $birthday){
		$this->birthday = $birthday;
	}
	
	public function getEmail(){
		if(!isset($this->email)){
			$this->email = self::$model->getUserEmailByPerson($this);
		}
		return $this->email;
	}
	
	public function init(){
		if(isset($this->id)){
			self::$model->getPersonData($this);
		} else {
			throw new Exception("No ID set, so cannot initialize");
		}
	}

}