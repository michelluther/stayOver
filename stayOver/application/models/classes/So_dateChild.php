<?php
class SO_DateChild extends SO_DateBase{
	
	protected $children = array();
	protected $things = array();
	
	public function __construct($id = null){
		parent::__construct($id);
	}
	public function addChild($child){
		array_push($this->children, $child);
	}
	
	public function addThing(SO_ThingBase $thing){
		$things[$thing->getID()] = $thing;
	}
	
	public function removeThing(SO_ThingBase $thing){
		unset($this->things[$thing->getID()]);
	}
	
	public function getThings(){
		return $this->things;
	}
}