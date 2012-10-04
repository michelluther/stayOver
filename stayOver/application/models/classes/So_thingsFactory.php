<?php

final class SO_ThingsFactory{
	
	private $model;
	private $things = array();
	
	public static function setModel($model){
		// Might not be the most loosely coupled way ... factory sets model for classes
		self::$model = $model;
		SO_ThingBase::setModel($model);
	}
	
	public function cacheThing(SO_ThingBase $thing){
		$things[$thing->getID()] = $thing;
	}
	
}