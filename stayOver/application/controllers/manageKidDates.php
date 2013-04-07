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
			$this->content['data']['parentDates'] = $user->getParent()->getDates(new DateTime(null, new DateTimeZone(DateT::Europe)));
			$this->content['data']['parentChildren'] = $user->getParent()->getChildren();
		} catch (Mpm_Exception $e) {
			$this->content['data']['parentDates'] = null;
		}
		$this->_callView();
	}

	public function getDates(){
		$this->returnType = MLU_AJAX_CONTENT;
		$user = SO_User::getInstance();
		$this->content['data']['parentDates'] = $user->getParent()->getDates(new DateTime(null, new DateTimeZone(DateT::Europe)));
		$this->content['view'] = 'include/dateTable';
		$this->_callView();
	}

	public function addDate(){
		$clientArray = $_POST["form"]["date"];
		try {
			$this->returnType = MLU_AJAX_DATA;
			$begin = Mpm_calendar::get_date_from_user_string($clientArray["beginDate"]);
			Mpm_calendar::set_time_from_user_string($begin, $clientArray["beginTime"]);
			$end = Mpm_calendar::get_date_from_user_string($clientArray["endDate"]);
			Mpm_calendar::set_time_from_user_string($end, $clientArray["endTime"]);
			$newDate = SO_DateFactory::createNewDate(
					$begin,
					$end,
					$clientArray["title"],
					null,
					$clientArray["kid"]);
			if ($clientArray["note"] != 'null') {
				$newDate->setNote($clientArray["note"]);
			}
			$newDate->save();
			$this->informHelpersOfNewDate($newDate);
			$this->_returnFeedback(BASE_MSG_SUCCESS, 'Termin erfolgreich angelegt');
		} catch (Exception $e) {
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function removeDate($dateID){
		try {
			$date = SO_DateFactory::getDate($dateID);
			$date->delete();
			$this->_returnFeedback(BASE_MSG_SUCCESS, 'Termine erfolgreich gel&ouml;scht');
		} catch (Mpm_Exception $e) {
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function changeDate($dateID){
		try{
			$clientArray = $_POST["form"]["date"];
			$date = SO_DateFactory::getDate($dateID);
			$begin = Mpm_calendar::get_date_from_user_string($clientArray["beginDate"]);
			Mpm_calendar::set_time_from_user_string($begin, $clientArray["beginTime"]);
			$end = Mpm_calendar::get_date_from_user_string($clientArray["endDate"]);
			Mpm_calendar::set_time_from_user_string($end, $clientArray["endTime"]);
			$childPerson = SO_PeopleFactory::getPerson($clientArray["kid"]);
			$child = new SO_Child($childPerson);
			$title = $clientArray['title'];
			$note = $clientArray['note'];
			$date->setTitle($title);
			$date->setBeginDate($begin);
			$date->setEndDate($end);
			$date->setNote($note);
			$date->removeChildren();
			$date->addChild($child);
			$changesMade = $date->save();
			$this->informHelpersOfChangeToDate($date);
			if($changesMade == true){
				$this->_returnFeedback(BASE_MSG_SUCCESS, 'Termin erfolgreich gespeichert');
			} else {
				$this->_returnFeedback(BASE_MSG_SUCCESS, 'Es wurden keine &Auml;nderungen vorgenommen');
			}
		} catch(Mpm_Exception $e) {
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function assignDate($dateID, $helperID = null){
		try{
			if($helperID == null){
				$helperObject = $this->user->getHelper();
				$helper = SO_PeopleFactory::getPerson($helperObject->getID());
			} else {
				$helper = SO_PeopleFactory::getPerson($helperID);
			}
			$date = SO_DateFactory::getDate($dateID);
			$date->removeHelpers();
			$date->addHelper($helper);
			$changesMade = $date->save();
			$this->_returnFeedback(BASE_MSG_SUCCESS, 'Termine erfolgreich zugewiesen');
		} catch (Exception $e) {
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

	public function unassignDate($dateID){
		try{
			$date = SO_DateFactory::getDate($dateID);
			$date->removeHelpers();
			$changesMade = $date->save();
			$this->_returnFeedback(BASE_MSG_SUCCESS, 'Der Termin wurde frei gegeben.');
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
	public function getAddDate(){
		$this->returnType = MLU_AJAX_CONTENT;
		$this->content['view'] = 'popins/add_date_form';
		$user = SO_User::getInstance();
		$this->content['data']['children'] = $user->getParent()->getChildren();
		$this->_callView();
	}

	public function getDeleteDatesConfirm($dateID){
		$this->returnType = MLU_AJAX_CONTENT;
		$date = SO_DateFactory::getDate($dateID);
		$this->content['data']['date'] = $date;
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

	public function getAssignDateForm($dateID){
		$this->returnType = MLU_AJAX_CONTENT;
		try{
			$helpers = array();
			$children = array();
			$date = SO_DateFactory::getDate($dateID);
			// Helfer sind alle Helfer, die f�r die Kinder eingetragen sind
			$children = $this->user->getParent()->getChildren();
			foreach ($children as $child){
				$helpersTmp = $child->getHelpers();
				foreach ($helpersTmp as $helperTmp) {
					$helpers[$helperTmp->getID()] = $helperTmp;
				}
			}
			$this->content['data']['date'] = $date;
			$this->content['data']['helpers'] = $helpers;
			$this->content['view'] = 'popins/assign_date_form';
			$this->_callView();
		} catch(Mpm_Exception $e){
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function getAssignDateToSelfForm($dateID){
		$this->returnType = MLU_AJAX_CONTENT;
		try{
			$dates = array();
			$helpers = array();
			$children = array();
			$date = SO_DateFactory::getDate($dateID);
			array_push($dates, $date);
			$this->content['data']['dates'] = $dates;
			$this->content['view'] = 'popins/assign_date_to_self_form';
			$this->_callView();
		} catch(Mpm_Exception $e){
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function getUnassignDatesForm($dateID){
		$this->returnType = MLU_AJAX_CONTENT;
		try{
			$date = SO_DateFactory::getDate($dateID);
			$this->content['data']['date'] = $date;
			$this->content['view'] = 'popins/unassign_date_form';
			$this->_callView();
		} catch(MPM_Exception $e){
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	// End of Form Management

	private function getHelpersOfParent(){
		$children = $user->getParent()->getChildren();
		$helpers = array();
		foreach ($children as $child) {
			$childHelpers = $child->getHelpers();
		}
	}

	private function informHelpersOfNewDate(SO_DateChild $date){
		// Compose Mail
		// Get Recipients
		$kids = $date->getChildren();
		foreach ($kids as $kid) {
			$this->email->clear();
			$this->email->from(BASE_MAIL_FROM, BASE_MAIL_FROM_TEXT);
			$this->email->subject('Ein neuer Termin für ' . $kid->getName() );
			$emailMessage = $this->_setEmailHTMLHeader();
			$emailMessage .= $this->_setEmailHTMLBody('<p>Hallo lieber Helfer</p><p>f&uuml;r Dein Helfer-Kind ' . $kid->getName() . ' gibt es einen neuen Termin am '
					. Mpm_calendar::format_date_for_User($date->getBeginDate())
					. '</p><p>Du kannst Dich bei StayOver anmelden und Dir die offenen Termine ansehen.</p>'
					. '<p>Liebe Grüße<br />
					Dein StayOver</p>');
			$emailMessage .= $this->_setEmailHTMLFooter();
			$this->email->message($emailMessage);
			$helpers = $kid->getHelpers();
			foreach ($helpers as $helper) {
				try{
					$this->email->to($helper->getEmail());
					$this->email->send();
				} catch (Mpm_Exception $e) {
					// do nothing
				}
			}
		}
	}

	private function informHelpersOfChangeToDate(SO_DateChild $date){
		$kids = $date->getChildren();
		foreach ($kids as $kid) {
			$this->email->clear();
			$this->email->from(BASE_MAIL_FROM, BASE_MAIL_FROM_TEXT);
			$this->email->subject('Änderungen an Termin für ' . $kid->getName() );
			$emailMessage = $this->_setEmailHTMLHeader();
			$emailMessage .= $this->_setEmailHTMLBody('<p>Hallo lieber Helfer,</p>'
					. '<p>f&uuml;r Dein Helfer-Kind ' . $kid->getName() . ' gab es eine Änderung an dem Termin "'
					. $date->getTitle() .'" am ' .Mpm_calendar::format_date_for_User($date->getBeginDate())
					. '.</p><p>Du kannst Dich bei StayOver anmelden und Dir die Änderungen ansehen.</p>');
			$emailMessage .= $this->_setEmailHTMLFooter();
			$this->email->message($emailMessage);
			$helpers = $kid->getHelpers();
			foreach ($helpers as $helper) {
				try{
					$this->email->to($helper->getEmail());
					$this->email->send();
				} catch (Mpm_Exception $e) {
					// do nothing
				}
			}
		}
	}
}