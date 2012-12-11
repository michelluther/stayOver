<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'so_base_controller.php';

class Settings extends SO_BaseController{

	public function __construct(){
		parent::__construct();
	}

	public function start(){
		$this->header['data']['js'] = array('settings');
		$this->content['data']['user'] = $this->user;
		$parent = $this->user->getParent();
		if ($parent != null){
			$kids = $parent->getChildren();
		}
		$this->content['data']['kids'] = $kids;
		$this->content['view'] = 'settings';
		$this->_callView();
	}
	
	public function saveUserData(){
		$clientArray = $_POST["form"]["user"];
		
	}
	
	public function removeHelper($kidID, $helperID){
		$parent = $this->user->getParent();
		try{
		if ($parent != null){
			$helper = SO_PeopleFactory::getPerson($helperID);
			$kid = SO_PeopleFactory::getPerson($kidID);
			$parent->unassignHelperFromChild($kid, $helper);
			$this->_returnFeedback(BASE_MSG_SUCCESS, "Helfer erfolgreich entfernt");
		}
		} catch(Mpm_Exception $e){ 
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}
}