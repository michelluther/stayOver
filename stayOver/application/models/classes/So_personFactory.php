<?php
include_once 'So_parent.php';

class SO_PeopleFactory{
	private static $people = array();
	private static $model;
	
	public static function setModel($model){
		// Factory knows all the 
		self::$model = $model;
		SO_Person::setModel($model);
	}
	
// 	public static function getModel(){
// 		return $this->model;
// 	}
	
	public static function getPerson($id){
		if (!isset(self::$people[$id])){
			$person = new SO_Person(self::$model, $id);
			self::compose($person);
			self::$people[$id] = $person;
		}
		return self::$people[$id];
	}
	
	public static function createPerson($firstName, $lastName){
		$person = new SO_Person($this->model);
		$person->setFirstName($firstName);
		$person->setLastName($lastName);
	}
	
	private static function compose(SO_Person &$person){
		self::addParent($person);
	}
	
	private static function addParent(SO_Person &$person){
		$user = SO_User::getInstance(null);
		if ($user->hasRole('eltern')){
			$person->setParent(new SO_Parent($person));
		}
	}
	
	private static function addParent(SO_Person &$person){
		if (self::$model->getIsHelper($person)){
			$person->setHelper(new SO_Helper($person));
		}
	}

}