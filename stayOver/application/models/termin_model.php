<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Data base abstraction for dates
require_once 'interfaces/Mpm_jsondata.php';
require_once 'classes/So_jsonData.php';
require_once 'classes/So_personFactory.php';
require_once 'classes/So_dateFactory.php';
require_once 'classes/So_dateBase.php';
require_once 'classes/So_dateChild.php';

class Termin_model extends CI_Model{

	public function __construct(){
		SO_DateFactory::setModel($this);
	}

	// Readers
	public function getDatesByPeriod($beginDate, $endDate){
		$where = array(	'begda >=' => $beginDate,
				'endda <=' => $endDate,
				'deleted' => false);
		$this->db->select('id');
		$this->db->from('so_dates');
		$this->db->where($where);
		$query = $this->db->get();
		$returnDates = array();
		if($query != false){
			foreach ($query->result() as $value) {
				array_push($returnDates, SO_DateFactory::getDate($value->id));
			}
		}
		return $returnDates;
	}

	public function getDatesByChild(IF_BASE_NAMED_OBJECT $child, DateTime $periodBeginDate = null, DateTime $periodEndDate = null, IF_BASE_NAMED_OBJECT $helper = null){
		$where = array('child_id =' => $child->getID(),
				'so_dates.deleted =' => false );
		if($periodBeginDate != null){
			$beginDate = Mpm_Calendar::format_date_for_DataBase($periodBeginDate);
			$where['begda >='] = $beginDate;
		}
		if($periodEndDate != null){
			$endDate = Mpm_Calendar::format_date_for_DataBase($periodEndDate);
			$where['begda <='] = $endDate;
		}
		$this->db->select('*');
		$this->db->from('so_date_child');
		$this->db->join('so_dates', 'so_date_child.date_id = so_dates.id');
		if($helper != null){
			$this->db->join('so_date_helper', 'so_dates.id = so_date_helper.date_id');
			$where['so_date_helper.helper_id'] = $helper->getID();
		}
		$this->db->where($where);
		$query = $this->db->get();
		$returnDates = array();
		if($query != false){
			foreach ($query->result() as $value) {
				$returnDates[$value->begda . '_' . $value->date_id] = SO_DateFactory::getDate($value->date_id);
			}
		}
		return $returnDates;
	}

	public function getOpenDatesByChild(IF_BASE_NAMED_OBJECT $child, IF_BASE_NAMED_OBJECT $helper = null, DateTime $periodBeginDate = null, DateTime $periodEndDate){
		$where = array('so_date_child.child_id' => $child->getID(),
				'so_dates.deleted' => false );
		if($periodBeginDate != null){
			$beginDate = Mpm_Calendar::format_date_for_DataBase($periodBeginDate);
			$where['begda >='] = $beginDate;
		}
		if($periodEndDate != null){
			$endDate = Mpm_Calendar::format_date_for_DataBase($periodEndDate);
			$where['begda <='] = $endDate;
		}
		$this->db->select('*');
		$this->db->from('so_date_child');
		$this->db->join('so_dates', 'so_date_child.date_id = so_dates.id');
		$this->db->join('so_date_helper', 'so_dates.id = so_date_helper.date_id', 'left');
		$this->db->where($where);
		$query = $this->db->get();
		$returnDates = array();
		if($query != false){
			$result = $query->result();
			foreach ($result as $value) {
				if($value->helper_id == null){
					$returnDates[$value->begda . '_' . $value->id] = SO_DateFactory::getDate($value->id);
				}
			}
		}
		return $returnDates;
	}

	public function getDate($id){
		$where = array('id' => $id,
				'deleted' => false);
		$this->db->select('*');
		$this->db->from('so_dates');
		$this->db->where($where);
		$query = $this->db->get();
		if($query != false){
			foreach ($query->result() as $value) {
				$this->_projects[$value->id] = $value->name;
			}
		}
	}
	// Initialization
	public function initData(SO_DateChild $date){
		$this->db->select('*');
		$this->db->from('so_dates');
		$this->db->join('so_date_child', 'so_dates.id = so_date_child.date_id');
		$where = array('so_dates.id' => $date->getId());
		$this->db->where($where);
		$query = $this->db->get();
		if($query != false){
			foreach ($query->result() as $value) {
				$date->setTitle($value->title);
				$begin = Mpm_calendar::get_date_from_db_string($value->begda);
				Mpm_calendar::set_time_from_db_string($begin, $value->begtime);
				$date->setBeginDate($begin);
				$end = Mpm_calendar::get_date_from_db_string($value->endda);
				Mpm_calendar::set_time_from_db_string($end, $value->endtime);
				$date->setEndDate($end);
				$children = $this->_getDateChildren($date);
				foreach ($children as $child) {
					$date->addChild($child);
				}
				$helpers = $this->_getDateHelper($date);
				foreach ($helpers as $helper) {
					$date->addHelper($helper);
				}
				$date->setNote($value->note);
			}
		}
	}

	private function _getDateChildren(SO_DateChild $date){
		$where = array('date_id' => $date->getID());
		$this->db->from('so_date_child');
		$this->db->where($where);
		$this->db->select('child_id');
		$query = $this->db->get();
		$children = array();
		if($query != null){
			foreach ($query->result() as $value){
				$child = new SO_Child(SO_PeopleFactory::getPerson($value->child_id));
				array_push($children, $child);
			}
		}
		return $children;
	}

	private function _getDateHelper(SO_DateChild $date){
		$where = array('date_id' => $date->getID());
		$this->db->from('so_date_helper');
		$this->db->where($where);
		$this->db->select('helper_id');
		$query = $this->db->get();
		$helpers = array();
		if($query != null){
			foreach ($query->result() as $value){
				$helper = SO_PeopleFactory::getPerson($value->helper_id);
				array_push($helpers, $helper);
			}
		}
		return $helpers;
	}

	// Writers & Updater
	public function updateDate(SO_DateChild $date){
		$changesMade = false;
		$this->compareBeginAndEnd($date);
		$this->db->trans_begin();
		try{
			$changesMade = $this->_updateBaseData($date, $changesMade);
			$changesMade = $this->_updateChildData($date, $changesMade);
			$changesMade = $this->_updateHelperData($date, $changesMade);
			$helpers = $date->getHelpers();
		} catch (Exception $ex) {
			$this->db->trans_complete();
			$this->db->trans_rollback();
			throw $ex;
		}
		$this->db->trans_complete();
		$this->db->trans_commit();
		return $changesMade;
	}

	private function _updateBaseData(SO_DateChild $date, $changesMade){
		$dateData = array('id'		=> $date->getID(),
				'title' => $date->getTitle(),
				'begda' => Mpm_calendar::format_date_for_DataBase($date->getBeginDate()),
				'endda' => Mpm_calendar::format_date_for_DataBase($date->getEndDate()),
				'note' => $date->getNote()
		);
		$where = array('id' => $date->getId());
		$this->db->from('so_dates');
		$this->db->where($dateData);
		$query = $this->db->get();
		if($query == true){
			if(count($query->result()) == 0){
				$this->db->where($where);
				$this->db->update('so_dates', $dateData);
				if($this->db->_error_message() != null){
					throw new Mpm_Exception($this->db->_error_message());
				} else {
					$changesMade = true;
				}
			}
		}
		return $changesMade;
	}

	private function _updateChildData(SO_DateChild $date, $changesMade){
		$children = $date->getChildren();
		$childIDs = array();
		foreach ($children as $child) {
			array_push($childIDs, $child->getID());
		}
		// 		Get all children on DB
		$this->db->from('so_date_child');
		$this->db->where(array('date_id' => $date->getID()));
		$this->db->select('child_id');
		$query = $this->db->get();
		$childrenDB = array();
		if ($query == true){
			foreach ($query->result() as $entry) {
				array_push($childrenDB, $entry->child_id);
			}
		}
		$childrenToAdd = array_diff($childIDs, $childrenDB);
		$childrenToDelete = array_diff($childrenDB, $childIDs);
		foreach ($childrenToDelete as $childID) {
			$this->removeDateToChildAssignment($date, $childID);
			if($this->db->_error_message() != null){
				throw new Mpm_Exception($this->db->_error_message());
			} else {
				$changesMade = true;
			}
		}
		foreach ($childrenToAdd as $childID) {
			$this->assignDateToChild($date, $childID);
		}
		return $changesMade;
	}

	private function _updateHelperData(SO_DateChild $date, $changesMade){
		$helpers = $date->getHelpers();
		$helperIDs = array();
		foreach ($helpers as $helper) {
			array_push($helperIDs, $helper->getID());
		}
		// 		Get all helpers on DB
		$this->db->from('so_date_helper');
		$this->db->where(array('date_id' => $date->getID()));
		$this->db->select('helper_id');
		$query = $this->db->get();
		$helpersDB = array();
		if ($query == true){
			foreach ($query->result() as $entry) {
				array_push($helpersDB, $entry->helper_id);
			}
		}
		$helpersToAdd = array_diff($helperIDs, $helpersDB);
		$helpersToDelete = array_diff($helpersDB, $helperIDs);
		foreach ($helpersToDelete as $helperID) {
			$this->removeDateTohelperAssignment($date, $helperID);
			if($this->db->_error_message() != null){
				throw new Mpm_Exception($this->db->_error_message());
			} else {
				$changesMade = true;
			}
		}
		foreach ($helpersToAdd as $helperID) {
			$this->assignDateTohelper($date, $helperID);
		}
		return $changesMade;
	}

	public function insertDate(SO_DateChild $date){
		$CI =& get_instance();
		$successful = true;
		$this->compareBeginAndEnd($date);
		$beginDate = Mpm_Calendar::format_date_for_DataBase($date->getBeginDate());
		$beginTime = Mpm_calendar::format_time_for_DataBase($date->getBeginDate());
		if($date->getEndDate() == null){
			throw new Mpm_Exception('Endedatum nicht gesetzt');
		}
		$endDate = Mpm_Calendar::format_date_for_DataBase($date->getEndDate());
		$endTime = Mpm_calendar::format_time_for_DataBase($date->getEndDate());
		$this->db->trans_begin();
		try{
			// Base Data
				
			$dateData = array(
					'title' => $date->getTitle(),
					'begda' => $beginDate,
					'endda' => $endDate,
					'begtime' => $beginTime,
					'endtime' =>$endTime,
					'note' => $date->getNote(),
					'deleted' => false
			);
			$query = $this->db->insert('so_dates', $dateData);
			if($query == true){
				$id = $this->db->insert_id();
				$date->setId($id);
			} else {
				throw new Mpm_Exception('Fehler beim Schreiben des Tabelleneintrags');
			}
			// Children
			$children = $date->getChildren();
			if($children != null){
				foreach ($children as $child) {
					$this->assignDateToChild($date, $child->getID());
				}
			}
			// Helpers
			// ToDo: Helpers
		} catch (Exception $ex){
			$this->db->trans_complete();
			$this->db->trans_rollback();
			throw $ex;
		}
		$this->db->trans_complete();
		$this->db->trans_commit();
	}

	public function deleteDate(IF_BASE_NAMED_OBJECT $date){
		$where = array('id' => $date->getId());
		$dateData = array( 'deleted' => true );
		$this->db->where($where);
		$this->db->update('so_dates', $dateData);
	}

	private function assignDateToChild($date, $childID){
		$assignment = array('date_id' => $date->getId(),
				'child_id' => $childID);
		$query = $this->db->insert('so_date_child', $assignment);
		if($query != true){
			throw new Mpm_Exception('Fehler bei Speichern der Kindzuordnung');
		}
	}

	private function removeDateToChildAssignment($date, $childID){
		$where = array('date_id' => $date->getId(),
				'child_id' => $childID);
		$query = $this->db->delete('so_date_child', $where);
		if($query != true){
			throw new Mpm_Exception('Fehler bei Speichern der Kindzuordnung');
		}
	}

	private function assignDateToHelper(IF_BASE_NAMED_OBJECT $date, $helperID){
		$data = array('date_id' => $date->getID(),
				'helper_id' => $helperID,
				'deleted' => false );
		$query = $this->db->insert('so_date_helper', $data);
		if($query == false){
			throw new Mpm_Exception('Fehler beim Anlegen des Helfers f&uumlr den Termin');
		}
	}

	private function removeDateToHelperAssignment($date, $helperID){
		$where = array('date_id' => $date->getId(),
				'helper_id' => $helperID);
		$query = $this->db->delete('so_date_helper', $where);
		if($query != true){
			throw new Mpm_Exception('Fehler bei Speichern der Kindzuordnung');
		}
	}

	private function compareBeginAndEnd($date){
		$beginDate = Mpm_Calendar::format_date_for_DataBase($date->getBeginDate());
		$beginTime = Mpm_calendar::format_time_for_DataBase($date->getBeginDate());
		if($date->getEndDate() == null){
			throw new Mpm_Exception('Endedatum nicht gesetzt');
		}
		$endDate = Mpm_Calendar::format_date_for_DataBase($date->getEndDate());
		$endTime = Mpm_calendar::format_time_for_DataBase($date->getEndDate());
		if(($endDate < $beginDate) || (($endDate == $beginDate) && ($endTime <= $beginTime))){
			throw new Mpm_Exception('Das Ende muss hinter dem Anfang liegen');
		}
	}
}