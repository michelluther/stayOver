<?php

class SO_DateFactory{
	
	private static $model;
	private static $dates = array();
	
	public static function setModel($model){
// Might not be the most loosely coupled way ... factory sets model for classes
		self::$model = $model;
		SO_dateBase::setModel($model);
	}
	
	public static function getDate($id){
		if(!isset($dates[$id])){
			$dates[$id] = new SO_DateChild($id);
			$dates[$id]->init();
		} 
		return $dates[$id];
	}
		
	public static function createNewDate($beginDate, $endDate = null, $title = null, $beginTime = null, $endTime = null, $note = null, $kids = null){
		$date = new SO_DateChild();
		if($beginDate != null){
			$date->setBeginDate($beginDate);
		} else {
			throw new Mpm_Exception('Wenigstens ein Beginndatum muss angegeben werden.');
		}
		if($endDate != null){
			$date->setEndDate($endDate);
		}
		if($title != null){
			$date->setTitle($title);
		}
		if($beginTime != null){
			$date->setBeginTime($beginTime);
		}
		if($endTime != null){
			$date->setEndTime($endTime);
		}
		if($note != null){
			$date->setNote($note);
		}
		if($kids != null){
			foreach ($kids as $kid) {
				;
			}
		}
		return $date;
	}
	
	public static function getDatesByPeriod($beginDate, $endDate){
		return self::$model->getDatesByPeriod($beginDate, $endDate);
	}
 
	public static function getDatesByRole($role, SO_Person $person){
		switch ($role) {
			case ROLE_PARENT:
				return self::$model->getDatesByParent($person->getParent()->getID());
			break;
			case ROLE_HELPER:
				
			default:
				;
			break;
		} 
	}
	
	public static function getDatesByChild(SO_Person $child){
		$dateIDs = self::$model->getDatesByChild($child->getID());
		$returnArray = array();
		foreach ($dateIDs as $dateID) {
			$date = self::getDate($dateID);
			array_push($returnArray, $date);
		}
		return $returnArray;
	}
	
	public static function cacheDate($date){
		$dates[$date->getId()] = $date;
	}
}