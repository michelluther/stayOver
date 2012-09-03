<?php

include_once 'classes/So_personFactory.php';
require_once 'interfaces/So_Interfaces.php';

class Person_model extends CI_Model{
	
	public function __construct(){
		SO_PeopleFactory::setModel($this);
	}
	
	public function getPersonName(IF_BASE_NAMED_OBJECT $person){
		
	}
	
	public function getPersonIsHelper(IF_BASE_NAMED_OBJECT $person){
		
	}	
			
	public function getChildrenByParent(IF_BASE_NAMED_OBJECT $parent){
		$where = array('parent_id' => $parent->getID());
		$query = $this->db->get_where('so_parent_child', $where);
		$result = $query->result();
		$returnArray = array();
		foreach ($result as $childEntry) {
			$child = SO_PeopleFactory::getPerson($childEntry->child_id);
			array_push($returnArray, $child);
		}
		return $returnArray;
	}
	
	public function getPersonIdByUser(IF_BASE_NAMED_OBJECT $user){
		$where = array(	'uname' => $user->getID());
		$query = $this->db->get_where('base_people', $where);
		$result = $query->result();
		$personResult = $result[0];
		return $personResult->pernr;
	}
	
	public function getPersonData(SO_Person $person){
		$where = array('pernr' => $person->getID());
		$query = $this->db->get_where('base_people', $where);
		$result = $query->result();
		$personResult = $result[0];
		$person->setFirstName($personResult->first_name);
		$person->setLastName($personResult->last_name);
	}
}