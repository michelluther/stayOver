<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'so_base_controller.php';

class StayOver extends SO_BaseController{

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		$this->home();
	}
	
	public function submit_login(){
		parent::submit_login();
	}

	public function home(){
		$helper = $this->user->getHelper();
		$beginDate = new DateTime(null, new DateTimeZone("Europe/Berlin"));
		if($helper != null){
			$this->content['data']['display']['helperDates'] = true;
			$this->content['data']['display']['helperOpenDates'] = true;
			$nextDatesHelper = $helper->getDates($beginDate);
			$this->content['data']['nextDatesHelper'] = $nextDatesHelper;
			$openDatesHelper = $helper->getOpenDates($beginDate);
			$this->content['data']['openDatesHelper'] = $openDatesHelper;
		}
		$parent = $this->user->getParent();
		if($parent != null){
			$this->content['data']['display']['parentDates'] = true;
			$user = $this->user;
			$nextDatesParent = $user->getParent()->getDates(new DateTime(null, new DateTimeZone("Europe/Berlin")));
			$this->content['data']['nextDatesParent'] = $nextDatesParent;
			//	$nextDatesParent
		}
		$this->content['view'] = 'home';
		$this->_callView();
	}

	public function viewDate($dateID){
		try{
			$date = SO_DateFactory::getDate($dateID);
			$this->returnType = MLU_AJAX_CONTENT;
			$this->content['view'] = 'popins/view_date_full';
			$this->content['data']['date'] = $date;
			$this->_callView();
		} catch(Mpm_Exception $e){
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function icalEntryPopup($dateID){
		try{
			$date = SO_DateFactory::getDate($dateID);
			$this->returnType = MLU_AJAX_CONTENT;
			$this->content['view'] = 'popins/send_download_ical';
			$this->content['data']['date'] = $date;
			$this->_callView();
		} catch(Mpm_Exception $e){
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function downloadIcalEntry($dateID){
		$date = SO_DateFactory::getDate($dateID);
		$user = SO_User::getInstance();
		$icalEntry = $this->so_ical->getIcalEntry($date, $user);
		$icalEntry->download();
	}

	public function sendIcalEntryToUser($dateID){
		try {
			$date = SO_DateFactory::getDate($dateID);
			$this->email->from(BASE_MAIL_FROM, BASE_MAIL_FROM_TEXT);
			$this->email->to($this->user->getEmail());
			$this->email->subject('Kalendereintrag für "' . $date->getTitle() . '"');
			$emailMessage = $this->_setEmailHTMLHeader();
			$emailMessage .= $this->_setEmailHTMLBody('<p>Hallo lieber Helfer,</p>'
													. '<p>hier ist der Kalendereintrag für den Termin am '
													. Mpm_calendar::format_date_for_User($date->getBeginDate())
													. '.</p>');
			$emailMessage .= $this->_setEmailHTMLFooter();
			$this->email->message($emailMessage);
			$icalEntry = $this->so_ical->getIcalEntry($date, $this->user);
			$icalString = $icalEntry->getiCalString();
			$this->email->string_attach($icalString, 'stayOver_ical_entry.ics', 'text/calendar');
			$this->email->send();
			$this->_returnFeedback(BASE_MSG_SUCCESS, 'Der Kalendereintrag wurde Dir per E-Mail zugesendet');
		} catch (Exception $e) {
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function openEmailToParents($dateID){
		$this->returnType = MLU_AJAX_CONTENT;
		$date = SO_DateFactory::getDate($dateID);
		$children = $date->getChildren();
		$parents = array();
		foreach ($children as $child) {
			$childParents = $child->getParents();
			$parents = array_merge($parents, $childParents);
		}
		$this->content['data']['parents'] = $parents;
		$this->content['data']['date'] = $date;
		$this->content['view'] = 'popins/sendMail';
		$this->_callView();
	}

	public function sendMailToParents($dateID){
		$this->returnType = MLU_AJAX_DATA;
		$date = SO_DateFactory::getDate($dateID);
		$children = $date->getChildren();
		$parents = array();
		foreach ($children as $child) {
			$childParents = $child->getParents();
			$parents = array_merge($parents, $childParents);
		}
		foreach ($parents as $parent) {
			$emailAddress = $parent->getEmail();
			$this->email->to($emailAddress);
		}
		$this->email->subject("Nachricht zu Termin: " . $date->getTitle());
		$mailTest = $_POST['form']['mail']['text'];
		$this->email->message($mailTest);
		$this->email->from($this->user->getEmail(), $this->user->getName());
		$this->email->send();
		$this->_returnFeedback(BASE_MSG_SUCCESS, $this->email->print_debugger());
	}

	public function getNextHelperDates(){
		$this->returnType = MLU_AJAX_CONTENT;
		$helper = $this->user->getHelper();
		$beginDate = new DateTime(null, new DateTimeZone("Europe/Berlin"));
		$nextDatesHelper = $helper->getDates($beginDate);
		$this->content['data']['nextDatesHelper'] = $nextDatesHelper;
		$this->content['view'] = 'include/nextDatesHelperList';
		$this->_callView();
	}

	public function getOpenHelperDates(){
		$this->returnType = MLU_AJAX_CONTENT;
		$helper = $this->user->getHelper();
		$beginDate = new DateTime(null, new DateTimeZone("Europe/Berlin"));
		$openDatesHelper = $helper->getOpenDates($beginDate);
		$this->content['data']['openDatesHelper'] = $openDatesHelper;
		$this->content['view'] = 'include/nextOpenDatesHelperList';
		$this->_callView();
	}

	public function getParentDates(){
		$this->returnType = MLU_AJAX_CONTENT;
		$user = $this->user;
		$nextDatesParent = $user->getParent()->getDates(new DateTime(null, new DateTimeZone("Europe/Berlin")));
		$this->content['data']['nextDatesParent'] = $nextDatesParent;
		$this->content['view'] = 'include/nextDatesParentTable';
		$this->_callView();
	}
}
