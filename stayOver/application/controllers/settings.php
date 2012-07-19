<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'so_base_controller.php';

class Settings extends SO_BaseController{

	public function __construct(){
		parent::__construct();
	}

	public function start(){
		$this->content['data'] = null;
		$this->content['view'] = 'settings';
		$this->_callView();
	}
}