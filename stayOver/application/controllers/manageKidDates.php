<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'so_base_controller.php';

class ManageKidDates extends SO_BaseController{
	public function __construct(){
		parent::__construct();
		$this->fault_view = 'manageKidDatesStart';
	}

	public function start(){
		SO_BaseController::$content['view'] = 'manageKidDatesStart';
		SO_BaseController::$content['data'] = null;
		$this->_callView();
	}

	public function addDate(){
		// ToDo: Extract Form/JSON-Data
		$clientArray = $_POST["date"];
		if($clientArray["singleDay"] == true){
			$clientArray["endDate"] = $clientArray["beginDate"];
		}
		try {
			$this->returnType = MLU_AJAX_DATA;
			$newDate = SO_DateFactory::createNewDate(	$clientArray["beginDate"],
																								$clientArray["endDate"],
																								$clientArray["title"]); // , $clientDate->kids, $clientDate->beginTime, $clientDate->endTime
			$newDate->save();
			SO_BaseController::_handleSuccess('Termin erfolgreich angelegt');
		} catch (Mpm_Exception $e) {
			SO_BaseController::$_handleError($e);
		}
		
	}

	public function removeDate(){
		// ToDo: Extract JSON-Data
		$dateToRemove = SO_DateFactory::getDate($id);
		$dateToRemove->delete();
	}
}