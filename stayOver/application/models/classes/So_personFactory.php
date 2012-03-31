<?php
include_once 'So_parent.php';

class SO_PeopleFactory{
	private static $people = array();
	
	public static function getPerson($id){
		if (!isset(self::$people[$id])){
			$person = new SO_Person($id);
			self::$people[$id] = $person;
		}
		return self::$people[$id];
	}
	
}