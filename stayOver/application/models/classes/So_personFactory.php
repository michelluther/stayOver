<?php

include_once 'application/models/interfaces/So_Interfaces.php';
include_once 'application/models/classes/So_parent.php';
include_once 'application/models/classes/So_person.php';
include_once 'application/models/classes/So_helper.php';

class SO_PeopleFactory{
	private static $people = array();
	private static $model;
	
	public static function setModel($model){
		// Factory knows all the 
		self::$model = $model;
		SO_Person::setPersonModel($model);
		SO_Parent::setPersonModel($model);
		SO_Helper::setPersonModel($model);
	}
		
	public static function getPerson($id){
		if (!isset(self::$people[$id])){
			$person = new SO_Person($id);
			$person->init();
			self::$people[$id] = $person;
		}
		return self::$people[$id];
	}
	
	public static function getPersonByUser(SO_User $user){
		$pernr = self::$model->getPersonIdByUser($user);
		return self::getPerson($pernr);
	}
	
	public static function createPerson($firstName, $lastName = null){
		$person = new SO_Person();
		$person->setFirstName($firstName);
		$person->setLastName($lastName);
	}


}