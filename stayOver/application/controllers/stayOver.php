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
		$nextDates = $helper->getDates($beginDate);
		$this->content['data']['nextDates'] = $nextDates;
		$this->content['view'] = 'home';
		$this->_callView();
	}
	
//	private function 
	
}
