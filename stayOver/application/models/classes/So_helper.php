<?php
class SO_Helper{
	
	private $person;
	
	public function __construct(IF_BASE_NAMED_OBJECT $person){
		$this->person = $person;
	}
	
	public function getName() {
		return $this->person->getName();
	}
	
	public function getID(){
		return $this->person->getID();
	}
	
}