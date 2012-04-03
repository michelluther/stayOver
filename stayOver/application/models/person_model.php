<?php

class Person_model extends CI_Model{
	
	public function __construct(){
		SO_PeopleFactory::setModel($this);
	}
	
	public function getPersonName($id){
		
	}
	
	public function getPersonIsHelper($id){
		
	}
	
	public function getPersonIsParent($id){
		
	}
	
}