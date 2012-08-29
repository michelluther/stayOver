<?php

class SO_Child {
	
	private $person;
	
	public function __construct($person){
		$this->person = $person;
	}
	
	public function getPerson(){
		return $this->person;
	}
	
}