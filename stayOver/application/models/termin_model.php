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
	
	public function getDatesByDate($beginDate, $endDate){
		$where = array(	'begda >=' => $beginDate,
					   		  	'endda <=' => $endDate);
		$this->db->select('id');
		$this->db->from('tts_dates');
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
	
	public function getDatesByStatus($status){
		
	}
	
	public function getDateById($id){
		$where = array('id' => $id);
		$this->db->select('*');
		$this->db->from('tts_dates');
		$this->db->where($where);
		$query = $this->db->get();
		if($query != false){
			foreach ($query->result() as $value) {
				$this->_projects[$value->id] = $value->name;
			}
		}		
	}
	
	// DB-Interface
	public function getDateFromDB($id){
		
	}
	
	public function initData($dateObject){
		$where = array('id' => $dateObject->getId());
		$this->db->select('*');
		$this->db->from('tts_dates');
		$this->db->where($where);
		$query = $this->db->get();
		if($query != false){
			foreach ($query->result() as $value) {
				$dateObject->setTitle($value->title);
			}
		}
	}
}