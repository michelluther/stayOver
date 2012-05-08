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
		
	public static function createNewDate($beginDate, $endDate, $beginTime, $endTime){
		return new SO_DateChild($beginDate, $endDate, $beginTime, $endTime, $title);
	}
	
	public static function getDatesByPeriod($beginDate, $endDate){
		return self::$model->getDatesByPeriod($beginDate, $endDate);
	}
 
}