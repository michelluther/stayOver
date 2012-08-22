<?php

include_once 'classes/So_personFactory.php';
include_once 'classes/So_personFactory.php';

class Person_model extends CI_Model{
	
	public function __construct(){
		SO_PeopleFactory::setModel($this);
		SO_User::setPersonModel($this);
	}
	
	public function getPersonName($id){
		
	}
	
	public function getPersonIsHelper($id){
		
	}	
		
	public function getPersonByUser(SO_User	&$user){
		$where = array(	'uname' => $user->uname);
		$query = $this->db->get_where('base_people', $where);
		$result = $query->result();
		$personResult = $result[0];
		$person = SO_PeopleFactory::getPerson($personResult->pernr);
		$user->setAssignedPerson($person);
	}
	
}