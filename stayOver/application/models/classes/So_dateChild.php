<?php
class SO_DateChild extends SO_DateBase{
	
	protected $children = array();
	protected $things = array();
	protected $helpers = array();
	
	public function __construct($id = null){
		parent::__construct($id);
	}
	
	public function init(){
		self::$model->initData($this);
		$this->isChanged = false;
	}
	
	public function addChild(SO_Person $child){
		array_push($this->children, $child);
	}
	
	public function addThing(SO_ThingBase $thing){
		$things[$thing->getID()] = $thing;
	}
	
	public function addHelper(SO_Person $helper){
		$this->helpers[$helper->getID()] = $helper;
	}
	
	public function removeHelper(SO_Person $helper){
		unset($this->helpers[$helper->getID()]);
	}
	
	public function removeThing(SO_ThingBase $thing){
		unset($this->things[$thing->getID()]);
	}
	
	public function getThings(){
		return $this->things;
	}
	
	public function getChildren(){
		return $this->children;
	}
	
	public function getHelpers(){
		return $this->helpers;
	}
}