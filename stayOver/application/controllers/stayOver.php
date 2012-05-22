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
		$nextDates = So_dateFactory::getDatesByPeriod('1.1.2012', '31.3.2012');
		$this->content['data']['nextDates'] = $nextDates;
		$this->content['view'] = 'home';
		$this->_callView();
	}
	
	public function addDate(){
		$this->content['view'] = 'addDate';
	}
	
}
