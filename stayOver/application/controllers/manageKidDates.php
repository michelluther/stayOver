<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'so_base_controller.php';

class ManageKidDates extends SO_BaseController{
	public function __construct(){
		parent::__construct();
	}
	
	public function start(){
		$this->content['view'] = 'manageKidDatesStart';
		$this->content['data'] = null;
		$this->_callView();
	}
	
	public function addDate(){
		// ToDo: Extract Form/JSON-Data
		$newDate = SO_DateFactory::createNewDate($beginDate, $endDate, $beginTime, $endTime);
		if (count($children) <> 0){
			foreach ($children as $child) {
				$newDate->addChild($child);
			}
		}
		$newDate->save();
	}
	
	public function removeDate(){
		// ToDo: Extract JSON-Data
		$dateToRemove = SO_DateFactory::getDate($id);
		$dateToRemove->delete();
	}
}