<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'so_base_controller.php';

class ManageKidDates extends SO_BaseController{
	public function __construct(){
		parent::__construct();
		$this->fault_view = 'manageKidDatesStart';
	}
	// Date Management
	public function start(){
		$this->content['view'] = 'manageKidDatesStart';
		try {
			$user = SO_User::getInstance();
			$this->content['data']['parentDates'] = $user->getParent()->getDates(new DateTime());
			$this->content['data']['parentChildren'] = $user->getParent()->getChildren();
		} catch (Mpm_Exception $e) {
			$this->content['data']['parentDates'] = null;
		}
		$this->_callView();
	}

	public function getDates(){
		$this->returnType = MLU_AJAX_CONTENT;
		$this->content['data']['parentDates'] = $user->getParent()->getDates(new DateTime());
		$this->content['view'] = 'includes/dateTable';
	}
	
	public function addDate(){
		// ToDo: Extract Form/JSON-Data
		$clientArray = $_POST["form"]["date"];
		$singleDay = $clientArray["singleDay"];
		if($singleDay == 'on'){
			$clientArray["endDate"] = $clientArray["beginDate"];
		}
		try {
			$this->returnType = MLU_AJAX_DATA;
			$newDate = SO_DateFactory::createNewDate(Mpm_calendar::get_date_from_user_string($clientArray["beginDate"]),
					Mpm_calendar::get_date_from_user_string($clientArray["endDate"]),
					$clientArray["title"],
					null,
					null,
					null,
					$clientArray["kid"]);
			if ($clientArray["note"] != 'null') {
				$newDate->setNote($clientArray["note"]);
			}
			$newDate->save();
			$this->_returnFeedback(BASE_MSG_SUCCESS, 'Termin erfolgreich angelegt');
		} catch (Mpm_Exception $e) {
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function removeDates(){
		// ToDo: Extract JSON-Data
		$selectedDates = $_POST['dates'];
		$dates = array();
		foreach ($selectedDates as $dateID) {
			$date = SO_DateFactory::getDate($dateID);
			$date->delete();
		}
		$this->_returnFeedback(BASE_MSG_SUCCESS, 'Termine erfolgreich gelöscht');
	}

	public function changeDate($dateID){
		try{
			$clientArray = $_POST["date"];
			$date = SO_DateFactory::getDate($dateID);
			$beginDate = Mpm_calendar::get_date_from_user_string($clientArray["beginDate"]);
			$endDate = Mpm_calendar::get_date_from_user_string($clientArray["endDate"]);
			$child = SO_PeopleFactory::getPerson($clientArray["kid"]);
			$title = $clientArray['title'];
			$note = $clientArray['note'];
			$date->setTitle($title);
			$date->setBeginDate($beginDate);
			$date->setEndDate($endDate);
			$date->setNote($note);
			//$date->addChild($child);
			$date->save();
			$this->_returnFeedback(BASE_MSG_SUCCESS, 'Termin erfolgreich gespeichert');
		} catch(Mpm_Exception $e) {
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	// Form Management
	public function getDeleteDatesConfirm(){
		$this->returnType = MLU_AJAX_CONTENT;
		$selectedDates = $_POST['dates'];
		$dates = array();
		foreach ($selectedDates as $dateID) {
			$date = SO_DateFactory::getDate($dateID);
			array_push($dates, $date);
		}
		$this->content['data']['dates'] = $dates;
		$this->content['view'] = 'popins/delete_dates_confirm';
		$this->_callView();
	}

	public function getChangeDateForm($dateID){
		try{
			$date = SO_DateFactory::getDate($dateID);
			$parent = $this->user->getParent();
			$this->returnType = MLU_AJAX_CONTENT;
			$this->content['data']['date'] = $date;
			$this->content['data']['parentChildren'] = $parent->getChildren();
			$this->content['view'] = 'popins/change_date_form';
			$this->_callView();
		} catch (Mpm_Exception $e){
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function getAssignDatesForm(){
		$this->returnType = MLU_AJAX_CONTENT;
		try{
			$selectedDates = $_POST['dates'];
			$dates = array();
			$helpers = array();
			$children = array();
			foreach ($selectedDates as $dateID) {
				$date = SO_DateFactory::getDate($dateID);
				array_push($dates, $date);
			}
			// Helfer sind alle Helfer, die für die Kinder eingetragen sind
			$children = $this->user->getParent()->getChildren();
			foreach ($children as $child){
				$helpersTmp = $child->getHelpers();
				foreach ($helpersTmp as $helperTmp) {
					$helpers[$helperTmp->getID()] = $helperTmp;
				}
			}
			$this->content['data']['dates'] = $dates;
			$this->content['data']['helpers'] = $helpers;
			$this->content['view'] = 'popins/assign_date_form';
			$this->_callView();
		} catch(Mpm_Exception $e){
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}
	
	private function getHelpersOfParent(){
		$children = $user->getParent()->getChildren();
		$helpers = array();
		foreach ($children as $child) {
			$childHelpers = $child->getHelpers();
		}
	}
}