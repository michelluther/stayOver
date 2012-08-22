<?php

include_once 'So_person.php';

class SO_Parent extends SO_Person{

	private $children = array();

	public function __construct(SO_Person $person){
		
	}

	public function add_child($id){
		if (!isset($children[$id])){
			$children[$id] = ChildFactory::get_child($id);
		}
	}
	
	public function get_children(){
		return $this->children;
	}

	public function remove_child($id){
		// unset($this->children($id));
	}
	
	

}