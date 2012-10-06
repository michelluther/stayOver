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

	public function getDatesByPeriod($beginDate, $endDate){
		$where = array(	'begda >=' => $beginDate,
										'endda <=' => $endDate);
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

	public function getDatesByChild(IF_BASE_NAMED_OBJECT $child, $periodBeginDate = null, $periodEndDate = null){
		$where = array('child_id =' => $child->getID());
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
	
	public function getDate($id){
		$where = array('id' => $id);
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

	// DB-Interface

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
				$date->setBeginDate(Mpm_calendar::get_date_from_db_string($value->begda));
				$date->setEndDate(Mpm_calendar::get_date_from_db_string($value->endda));
				$child = SO_PeopleFactory::getPerson($value->child_id);
				$date->addChild($child);
			}
		}
	}

	public function updateDate(SO_DateChild $date){
		$dateData = array(	'title' => $date->getTitle(),
				'begda' => $date->getBeginDate(),
				'endda' => $date->getEndDate(),
				'begtime' => $date->getBeginTime(),
				'endtime' =>$date->getEndTime(),
				'note' => $date->getNote()
		);
		$where = array('id' => $date->getId());
		$this->db->where($where);
		$this->db->update('so_dates', $dateData);
	}

	public function insertDate(SO_DateChild $date){
		$CI =& get_instance();
		$beginDate = Mpm_Calendar::format_date_for_DataBase($date->getBeginDate());
		if($date->getEndDate() == null){
			throw new Mpm_Exception('Endedatum nicht gesetzt');
		}
		$endDate = Mpm_Calendar::format_date_for_DataBase($date->getEndDate());
		$dateData = array(	
							'title' => $date->getTitle(),
							'begda' => $beginDate,
							'endda' => $endDate,
							'begtime' => $date->getBeginTime(),
							'endtime' =>$date->getEndTime(),
							'note' => $date->getNote()
		);
		$query = $this->db->insert('so_dates', $dateData);
		if($query == true){
			$id = $this->db->insert_id();
			$date->setId($id);
		} else {
			throw new Mpm_Exception('Fehler beim Schreiben des Tabelleneintrags');
		}
	}

	public function deleteDate(SO_D$date){
		$where = array('id' => $date->getId());
		$this->db->where($where);
		$this->db->delete('so_dates', $where);
	}

	public function assignDateToChild($date, $child){
		$assignment = array('date_id' => $date->getId(),
							'child_id' => $child->getId());
		$this->db->insert('so_date_child_assignment', $assignment);
	}

	public function removeDateToChildAssignment($date, $child){
		$where = array('date_id' => $date->getId(),
					   'child_id' => $child->getId());
		$this->db->delete('so_date_child_assignment', $where);
	}
}