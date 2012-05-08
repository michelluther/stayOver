<?php
class SO_DateChild extends SO_DateBase{
	
	protected $children = array();
	
	public function __construct($id = null){
		parent::__construct($id);
	}
	public function addChild($child){
		array_push($this->children, $child);
	}
}