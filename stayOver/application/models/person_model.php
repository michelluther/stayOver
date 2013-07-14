<?php

include_once 'classes/So_personFactory.php';
require_once 'interfaces/So_Interfaces.php';

class Person_model extends CI_Model{

	public function __construct(){
		SO_PeopleFactory::setModel($this);
	}
		
	public function getChildrenByParent(IF_BASE_NAMED_OBJECT $parent){
		$where = array('parent_id' => $parent->getID());
		$query = $this->db->get_where('so_parent_child', $where);
		$result = $query->result();
		$returnArray = array();
		foreach ($result as $childEntry) {
			$child = new SO_Child(SO_PeopleFactory::getPerson($childEntry->child_id));
			$returnArray['' . $child->getID()] = $child;
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
			$returnArray['' . $child->getID()] = $child;
		}
		return $returnArray;
	}

	public function getHelpersByChild(IF_BASE_NAMED_OBJECT $child){
		$where = array('child_id' => $child->getID());
		$this->db->where($where);
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
	
	public function getParentsByChild(IF_BASE_NAMED_OBJECT $child){
		$where = array('child_id' => $child->getID());
		$this->db->where($where);
		$this->db->select('parent_id');
		$query = $this->db->get('so_parent_child');
		$result = $query->result();
		$parents = array();
		foreach ($result as $parentEntry) {
			$person = SO_PeopleFactory::getPerson($parentEntry->parent_id);
			$parent = new SO_Helper($person);
			array_push($parents, $parent);
		}
		return $parents;
	}

	public function getPersonIdByUser(IF_BASE_NAMED_OBJECT $user){
		$where = array(	'uname' => $user->getID());
		$query = $this->db->get_where('base_people', $where);
		$result = $query->result();
		$personResult = $result[0];
		return $personResult->pernr;
	}
	
	public function getUserEmailByPerson(IF_BASE_NAMED_OBJECT $person){
		$where = array('base_people.pernr' => $person->getID());
		$this->db->from('base_users');
		$this->db->join('base_people', 'base_users.uname = base_people.uname');
		$this->db->select('base_users.email');
		$this->db->where($where);
		$query = $this->db->get();
		$result = $query->result();
		if(count($result) != 0){
			return $result[0]->email;
		} else {
			throw new Mpm_Exception('Keine Emailadresse gepflegt.');
		}
	}

	public function addParentToChildAssignment(IF_BASE_NAMED_OBJECT $parent, IF_BASE_NAMED_OBJECT $child){
		$changesMade = false;
		$data = array('parent_id' => $parent->getID(),
									'child_id' => $child->getID());
		$this->db->where($data);
		$query = $this->db->get('so_parent_child');
		$result = $query->result();
		if(count($result) == 0){
			$this->db->insert('so_parent_child', $data);
			$changesMade = true;
		} else {
			throw new Mpm_Exception('Kind ist den Eltern bereits zugewiesen');
		}
		return $changesMade;
	}
	
	public function removeParentToChildAssignment(IF_BASE_NAMED_OBJECT $parent, IF_BASE_NAMED_OBJECT $child){
		$changesMade = false;
		$data = array('parent_id' => $parent->getID(),
									'child_id' => $child->getID());
		$this->db->where($data);
		$query = $this->db->get('so_parent_child');
		$result = $query->result();
		if(count($result) != 0){
			$this->db->where($data);
			$this->db->delete('so_parent_child', $data);
			$changesMade = true;
		} else {
			throw new Mpm_Exception('Kind ist den Eltern bereits zugewiesen');
		}
		return $changesMade;
	}
	
	public function getPersonData(SO_Person $person){
		$where = array('pernr' => $person->getID());
		$query = $this->db->get_where('base_people', $where);
		$result = $query->result();
		$personResult = $result[0];
		$person->setFirstName($personResult->first_name);
		$person->setLastName($personResult->last_name);
	}

	public function removeHelperToChildAssignment(IF_BASE_NAMED_OBJECT $child, IF_BASE_NAMED_OBJECT $helper){
		$this->db->where(array(	'child_id' => $child->getID(),
								'helper_id' => $helper->getID()));
		$query = $this->db->delete('so_helper_child');
	}
	
	public function addHelperToChildAssignment(IF_BASE_NAMED_OBJECT $child, IF_BASE_NAMED_OBJECT $helper){
		$changesMade = false;
		$data = array( 'child_id' => $child->getID(),
									 'helper_id' => $helper->getID());
		$this->db->where($data);
		$query = $this->db->get('so_helper_child');
		if(count($query->result()) == 0){
			$this->db->insert('so_helper_child', $data);
			$changesMade = true;
		} 
		return $changesMade;
	}
	
	public function insertPerson(SO_Person $person){
		$data = array( 'first_name' => $person->getFirstName(),
					   'last_name' => $person->getLastName(),
					   'uname' => $person->getUname()
		);
		$query = $this->db->insert('base_people', $data);
		$id = $this->db->insert_id();
		return $id;
	}

	public function updatePersonalData(SO_Person $person){
		$changesMade = false;
		// Check if changes were made
		$data = array('pernr' => $person->getID(),
									 'first_name' => $person->getFirstName(),
									 'last_name' => $person->getLastName()
		);
		$query = $this->db->get_where('base_people', $data);
		if(count($query->result()) == 0){
			$where = array('pernr' => $person->getID());
			$this->db->where($where);
			$this->db->update('base_people', $data);
			if($this->db->_error_message() != null){
				throw new Mpm_Exception($this->db->_error_message());
			} else {
				$changesMade = true;
			}
		}
		return $changesMade;
	}

	public function getPeopleBySearchString($searchString){
		// searching by first name, last name
		$searchTerms = explode(" ", $searchString);
		$whereIsHelperString = "`is_helper` = TRUE";
		$iterator = 0;
		$searchNameString = "";
		foreach ($searchTerms as $searchTerm) {
			if($iterator > 0){
				$searchNameString = ' OR ' . $searchNameString;
			}
			$searchNameString = $searchNameString . "`first_name` LIKE '%" . $searchTerm . "%' OR ";
			$searchNameString = $searchNameString . "`last_name` LIKE '%" . $searchTerm . "%'";
		}
		$whereClause = $whereIsHelperString . ' AND ( ' . $searchNameString . ' ) ';
		$this->db->where($whereClause);
		$query = $this->db->get('base_people');
		$returnArray = array();
		foreach ($query->result() as $hit) {
			$person = SO_PeopleFactory::getPerson($hit->pernr);
			array_push($returnArray, $person);
		}
		return $returnArray;
	}
}