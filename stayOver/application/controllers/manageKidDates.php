<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'so_base_controller.php';

class ManageKidDates extends SO_BaseController{
	public function __construct(){
		parent::__construct();
		$this->fault_view = 'manageKidDatesStart';
	}

	public function start(){
		$this->content['view'] = 'manageKidDatesStart';
		$this->content['data'] = null;
		$this->_callView();
	}

	public function addDate(){
		// ToDo: Extract Form/JSON-Data
		$clientArray = $_POST["date"];
		$singleDay = $clientArray["singleDay"];
		if($singleDay == 'on'){
			$clientArray["endDate"] = $clientArray["beginDate"];
		}
		try {
			$this->returnType = MLU_AJAX_DATA;
			$newDate = SO_DateFactory::createNewDate(Mpm_calendar::get_date_from_user_string($clientArray["beginDate"]),
													 Mpm_calendar::get_date_from_user_string($clientArray["endDate"]),
													 $clientArray['title']);
			if ($clientArray["note"] != 'null') {
				$newDate->setNote($clientArray["note"]);
			}
			$newDate->save();
			$this->_returnFeedback(BASE_MSG_SUCCESS, 'Termin erfolgreich angelegt');
		} catch (Mpm_Exception $e) {
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
		
	}

	public function removeDate(){
			// ToDo: Extract JSON-Data
		$dateToRemove = SO_DateFactory::getDate($id);
		$dateToRemove->delete();
	}
}