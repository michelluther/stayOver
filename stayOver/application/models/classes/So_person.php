<?php

class SO_Person extends SO_JSONData {
	// Model is injected
	protected static $model;

	protected $id;
	protected $name;
	protected $helper;
	protected $parent;


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
	
	public function setParent(SO_Parent $parent){
		$this->parent = $parent;
	}

	public function getIsHelper(){
		if (!isset($this->helper)){
			return true;
		} else {
			return false;
		}
	}

	public function getIsParent(){
		if(!isset($this->parent)){
			return true;
		} else {
			return false;
		}
	}

	public function init(){
		if(isset($this->id)){
			self::$model->getPersonData($this->id);
		} else {
			throw new Exception("No ID set, so cannot initialize");
		}
	}

}