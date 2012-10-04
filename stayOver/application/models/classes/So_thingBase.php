<?php

class SO_ThingBase extends SO_JSONData implements IF_BASE_NAMED_OBJECT {
	// Model is injected ...
	protected static $model;
	protected $id;
	protected $name;
	protected $ownerID;

	public function __construct($id = null){
		if($id != null){
			$this->id = $id;
		}
	}

	public static function setModel($model){
		self::$model = $model;
	}

	public function getID(){
		return $this->id;
	}

	public function getName(){
		return $this->name;
	}

}