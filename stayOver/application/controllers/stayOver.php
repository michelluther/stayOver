<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'so_base_controller.php';

class StayOver extends SO_BaseController{

	public function __construct(){
		parent::__construct();
	}

	public function submit_login(){
		parent::submit_login();
		$this->home();
	}

	public function home(){
		$helper = $this->user->getHelper();
		$beginDate = new DateTime();
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
			$user = SO_User::getInstance();
			$nextDatesParent = $user->getParent()->getDates(new DateTime());
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
			$this->content['view'] = 'popins/view_date';
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
		$icalEntry = $this->so_ical->getIcalEntry($date);
		$icalEntry->download();
	}

	public function sendIcalEntryToUser($dateID){
		$date = SO_DateFactory::getDate($dateID);
		$this->email->from('michel.luther@gmail.com', 'Michel Luther');
		$this->email->to('luther@lutherundwinter.de');
		$this->email->subject('Kalendereintrag für "' . $date->getTitle() . '"');
		$this->email->message('eine Email für mich von mir ...');
		$this->email->send();
		$this->_returnFeedback(BASE_MSG_SUCCESS, $this->email->print_debugger());
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
			array_merge($parents, $childParents);
		}
		foreach ($parents as $parent) {
			$this->email->to($parent->getEmail());
		}
		$this->email->subject("Nachricht zu Termin: " . $date->getTitle());
		$this->email->message($_POST['form']['mail']['text']);
		$this->email->from($this->user->getEmail(), $this->user->getName());
	}

	public function getNextHelperDates(){
		$this->returnType = MLU_AJAX_CONTENT;
		$helper = $this->user->getHelper();
		$beginDate = new DateTime();
		$nextDatesHelper = $helper->getDates($beginDate);
		$this->content['data']['nextDatesHelper'] = $nextDatesHelper;
		$this->content['view'] = 'include/nextHelperDatesTable';
		$this->_callView();
	}
	
	public function getOpenHelperDates(){
		$this->returnType = MLU_AJAX_CONTENT;
		$helper = $this->user->getHelper();
		$beginDate = new DateTime();
		$openDatesHelper = $helper->getOpenDates($beginDate);
		$this->content['data']['openDatesHelper'] = $openDatesHelper;
		$this->content['view'] = 'include/nextOpenDatesHelperTable';
		$this->_callView();
	}
}
