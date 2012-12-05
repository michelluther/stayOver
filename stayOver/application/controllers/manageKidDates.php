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
		$user = SO_User::getInstance();
		$this->content['data']['parentDates'] = $user->getParent()->getDates(new DateTime());
		$this->content['view'] = 'include/dateTable';
		$this->_callView();
	}

	public function addDate(){
		$clientArray = $_POST["form"]["date"];
		$singleDay = $clientArray["singleDay"];
		if($singleDay == 'on'){
			$clientArray["endDate"] = $clientArray["beginDate"];
		}
		try {
			$this->returnType = MLU_AJAX_DATA;
			$newDate = SO_DateFactory::createNewDate(	Mpm_calendar::get_date_from_user_string($clientArray["beginDate"]),
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
		try {
			foreach ($selectedDates as $dateID) {
				$date = SO_DateFactory::getDate($dateID);
				$date->delete();
			}
			$this->_returnFeedback(BASE_MSG_SUCCESS, 'Termine erfolgreich gel&ouml;scht');
		} catch (Mpm_Exception $e) {
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function changeDate($dateID){
		try{
			$clientArray = $_POST["form"]["date"];
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
			$date->removeChildren();
			$date->addChild($child);
			$changesMade = $date->save();
			if($changesMade == true){
				$this->_returnFeedback(BASE_MSG_SUCCESS, 'Termin erfolgreich gespeichert');
			} else {
				$this->_returnFeedback(BASE_MSG_SUCCESS, 'Es wurden keine &Auml;nderungen vorgenommen');
			}
		} catch(Mpm_Exception $e) {
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function assignDates(){
		$selectedDates = $_POST['dates'];
		$dates = array();
		$helperID = $_POST['form']['date']['helper'];
		try{
			foreach ($selectedDates as $dateID) {
				$date = SO_DateFactory::getDate($dateID);
				$helper = SO_PeopleFactory::getPerson($helperID);
				if (isset($helper) && isset($date)){
					$date->removeHelpers();
					$date->addHelper($helper);
					$changesMade = $date->save();
				}
			}

			$this->_returnFeedback(BASE_MSG_SUCCESS, 'Termine erfolgreich zugewiesen');
		} catch (Exception $e) {
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function unassignDates(){
		$selectedDates = $_POST['dates'];
		$dates = array();
		try{
			foreach ($selectedDates as $dateID) {
				$date = SO_DateFactory::getDate($dateID);
				$date->removeHelpers();
				$changesMade = $date->save();
			}
			$this->_returnFeedback(BASE_MSG_SUCCESS, 'Termine erfolgreich zugewiesen');
		} catch (Exception $e) {
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
			// Helfer sind alle Helfer, die f�r die Kinder eingetragen sind
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

	public function getUnassignDatesForm(){
		$this->returnType = MLU_AJAX_CONTENT;
		try{
			$selectedDates = $_POST['dates'];
			$dates = array();
			foreach ($selectedDates as $dateID) {
				$date = SO_DateFactory::getDate($dateID);
				array_push($dates, $date);
			}
			$this->content['data']['dates'] = $dates;
			$this->content['view'] = 'popins/unassign_date_form';
			$this->_callView();
		} catch(MPM_Exception $e){
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	// End of Form Management

	public function downloadIcalEntry($dateID){
		$date = SO_DateFactory::getDate($dateID);
		$icalEntry = $this->so_ical->getIcalEntry($date);
		$icalEntry->download();
	}

	private function getHelpersOfParent(){
		$children = $user->getParent()->getChildren();
		$helpers = array();
		foreach ($children as $child) {
			$childHelpers = $child->getHelpers();
		}
	}
}