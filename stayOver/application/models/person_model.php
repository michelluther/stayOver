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
			$child = new SO_Child(SO_PeopleFactory::getPerson($childEntry->child_id));
			array_push($returnArray, $child);
		}
		return $returnArray;
	}
	
	public function getChildrenByHelper(IF_BASE_NAMED_OBJECT $helper){
		$where = array('helper_id' => $helper->getID());
		$query = $this->db->get_where('so_helper_child', $where);
		$result = $query->result();
		$returnArray = array();
		foreach ($result as $childEntry) {
			$child = new SO_Child(SO_PeopleFactory::getPerson($childEntry->child_id));
			array_push($returnArray, $child);
		}
		return $returnArray;
	}
	
	public function getHelpersByChild(IF_BASE_NAMED_OBJECT $child){
		$where = array('child_id' => $child->getID());
		$this->db->where = $where;
		$this->db->select('helper_id');
		$query = $this->db->get('so_helper_child');
		$result = $query->result();
		$helpers = array();
		foreach ($result as $helperEntry) {
			$person = SO_PeopleFactory::getPerson($helperEntry->helper_id);
			$helper = new SO_Helper($person);
			array_push($helpers, $helper);
		}
		return $helpers;
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