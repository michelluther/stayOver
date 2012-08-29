<?php

class SO_Person extends SO_JSONData implements IF_BASE_NAMED_OBJECT {
	// Model is injected
	protected static $model;

	protected $id;
	protected $name;

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
	
	public function init(){
		if(isset($this->id)){
			self::$model->getPersonData($this->id);
		} else {
			throw new Exception("No ID set, so cannot initialize");
		}
	}

}