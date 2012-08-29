<?php

include_once 'So_person.php';

class SO_Parent implements IF_BASE_NAMED_OBJECT{

// Model is injected
	protected static $model;
	
	private $person;
	private $children = array();		// SO_Person

	public static function setModel($model){
		self::$model = $model;
	}
	
	public function __construct(IF_BASE_NAMED_OBJECT &$person){
		$this->person = $person;
	}
	
	public function addChild(SO_Person $child){
		if (!isset($this->children[$child->getID()])){
			$children[$child->getID()] = $child;
		}
	}
	
	public function getPerson(){
		return $this->person;
	}
	
	public function removeChild($id){
		// unset($this->children($id));
	}
	
	public function getChildren(){
		if(!($this->children)){
			$this->children = self::$model->getChildrenByParent($this);
		}
		return $this->children;
	}
	
	public function getDates(){
		$children = $this->getChildren();
		foreach ($children as $child) {
			SO_DateFactory::getDatesByChild($child);
		}
	}
	
	public function getID(){
		$this->person->getID();
	}
	
	public function getName(){
		$this->person->getName();
	}
}