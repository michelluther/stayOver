<?php
class SO_DateFactory{
	
	private static $dates = array();
	
	public static function getDate($id){
		if(!isset($dates[$id])){
			$dates[$id] = new SO_DateChild($id);
			$dates[$id]->setID($id);
		} 
		return $dates[id];
	}
		
	public static function createNewDate($beginDate, $endDate, $beginTime, $endTime, $childID){
		$dates[$id] = new SO_DateChild($beginDate, $endDate, $beginTime, $endTime, $title, $childID);
	}
 
}