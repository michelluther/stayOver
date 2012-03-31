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
		} 
		return $dates[$id];
	}
		
	public static function createNewDate($beginDate, $endDate, $beginTime, $endTime, $childID){
		$dates[$id] = new SO_DateChild($beginDate, $endDate, $beginTime, $endTime, $title, $childID);
	}
 
}