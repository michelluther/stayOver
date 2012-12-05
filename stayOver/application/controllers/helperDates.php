<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'so_base_controller.php';

class HelperDates extends SO_BaseController{
	public function __construct(){
		parent::__construct();
		$this->fault_view = 'manageKidDatesStart';
	}
	// Date Management
	public function start(){
		$this->content['view'] = 'manageHelperDatesStart';
		try {
			$user = SO_User::getInstance();
			$this->content['data']['helperDates'] = $user->getHelper()->getDates(new DateTime());
			$this->content['data']['helperOpenDates'] = $user->getHelper()->getOpenDates(new DateTime());
			$this->content['data']['helperChildren'] = $user->getHelper()->getChildren();
		} catch (Mpm_Exception $e) {
			$this->content['data']['parentDates'] = null;
		}
		$this->_callView();
	}

	
	
}