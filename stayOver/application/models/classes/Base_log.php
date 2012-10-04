<?php

define('ACTIVITY_CREATE_DATE', 'CREATE_DATE');
define('ACTIVITY_CHANGE_DATE', 'CHANGE_DATE');
define('ACTIVITY_DATE_ASSIGN_HELPER', 'DATE_ASSIGN_HELPER');
define('ACTIVITY_DATE_UNASSIGN_HELPER', 'DATE_UNASSIGN_HELPER');
define('ACTIVITY_CHILD_ASSIGN_HELPER'. 'CHILD_ASSIGN_HELPER');
define('ACTIVITY_CHILD_UNASSIGN_HELPER', 'CHILD_UNASSIGN_HELPER');

class SO_BaseLog{
	
	private static $instance;
	
	public static function getInstance(){
		if (!isset(self::$instance)){
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	public function addEntry($activity, IF_BASE_NAMED_OBJECT $source, IF_BASE_NAMED_OBJECT $target){
			$user = SO_User::getInstance();
			$data = array('activity' => $activity,
										'user' => $user->getID(),
										'source_type' => $source->getType(),
										'source_id' => $source->getID(),
										'target_type' => $target->getType(),
										'target_id' => $target->getID() );
			$this->db->insert();
	}
	
	public function readLogByUser(IF_BASE_NAMED_OBJECT $user, TimeDate $beginDate, TimeDate $endDate){
		$where = array('user' => $user->getID());
		$this->db->select('*');
		$this->db->where($where);
		$query = $this->db->get();
		$returnArray = array();
		foreach ($query->result() as $dbLogEntry){
			$logEntry = new SO_BaseLogEntry($dbLogEntry);
			array_push($returnArray, $logEntry);
		}
	}
}

class SO_BaseLogEntry{
	
	private $activity;
	private $source;
	private $target;
	private $date;
	
	public function __construct($dbEntry){
		$this->activity = $dbEntry->activity;
		$this->source = SO_GenericFactory::getObject($dbEntry->source_type, $dbEntry->source_id);
		$this->target = SO_GenericFactory::getObject($dbEntry->target_type, $dbEntry->target_id);
		$this->date = Mpm_calendar::get_date_from_db_string($dbEntry->timestamp);
	}
	
}