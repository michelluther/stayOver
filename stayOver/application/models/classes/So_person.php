<?php

class SO_Person extends SO_JSONData{
	protected $id;
	protected $name;
	protected $isHelper;
	protected $isParent;
	
	public function __construct($id){
		$this->id = $id; 
		$this->name = $this->person_model->getPersonName($id);
	}
	
	public function getIsHelper(){
		if (!isset($this->isHelper)){
			$this->isHelper = $this->person_model->getPersonIsHelper($this->id);
		}
	}
}