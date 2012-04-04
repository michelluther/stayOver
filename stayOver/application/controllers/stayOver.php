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
		$nextDates = $this->Termin_model->getDatesByDate('1.1.2012', '31.3.2012');
		$this->content['data']['nextDates'] = $nextDates;
		$this->content['view'] = 'home';
		$this->_callView();
	}

	public function maintain_hours_personal(){
		$this->header['data']['js'][0] = 'mpm_hrs';
		$this->content['view'] = 'main_hours_pers_init';
		$this->content['data'] = null;
		$this->_callView();
	}
	
	public function create_new_hour_entry(){
		$this->	load->view('create_new_hour_entry');
	}
	
	public function project_work(){
		$this->content['view'] = 'project_work_init';
		$this->content['data'] = array('projects' => $this->Project_model->get_projects_for_employee($this->user->personal_id));
		$this->_callView();
	}
	
	public function init_project_data_ajax(){
		$this->returnType = MLU_AJAX_DATA;
		$projects = $this->Project_model->get_project_data_init();
		$this->content['data']['ajax_data'] = $projects;
		$this->_callView();
	}
	
	public function get_calendar_ajax($beginDate = null, $endDate = null){
		$this->returnType = MLU_AJAX_CONTENT;
		if ($beginDate == null){
			$beginDate = '01.01.2012';
			$endDate = '31.12.2012';
		}
		$calendarEntries = $this->mpm_calendar->get_calendar_days($beginDate, $endDate);
		$this->content['data']['calendarEntries'] = $calendarEntries;
		$this->content['view'] = 'main_hours_data';
		$this->_callView();
	}
	
	public function get_hours_data_ajax($beginDate = null, $endDate = null){
		$this->returnType = MLU_AJAX_DATA;
		$dateArray = Array();
		if ($beginDate == null){
			$dateArray = $this->mpm_calendar->getStringIntervalFromNow('P2M', 'P1W');
		} else {
			$dateArray['beginDate'] = $beginDate;
			$dateArray['endDate'] = $endDate;
		}
		$projectHours = $this->Project_model->get_hours_for_employee($this->user->personal_id, $dateArray['beginDate'], $dateArray['endDate']);
		$this->content['data']['ajax_data'] = $projectHours;
		$this->_callView();
	}
	
	public function submit_project_hours(){
		$this->returnType = MLU_AJAX_CONTENT;
		$this->content['view'] = 'system_feedback';
		$this->content['data']['msg_text'] = 'Super, Deine Daten sind am Server angekommen!';
		$this->content['data']['msg_class'] = 'success';
		$this->_callView();
	}
}
