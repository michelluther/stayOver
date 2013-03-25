<?php
/**
 * @author michel
 *
 */

include_once 'so_base_controller.php';

class Admin extends SO_BaseController{

	public function __construct(){
		parent::__construct();
		$this->controller_name = strtolower(get_class($this));
	}

	public function start(){
		$this->content['view'] = 'admin';
		$this->header['data']['js'] = array('admin');
		$this->content['data'] = null;
		$this->_callView();
	}

	public function addUser(){
		try{
			$uname = $_POST['form']['user']['uname'];
			$pw	= $_POST['form']['user']['password'];
			$email = $_POST['form']['user']['email'];
			$firstName = $_POST['form']['user']['firstName'];
			$lastName = $_POST['form']['user']['lastName'];
			$user = SO_User::createUser($uname, $pw, $email, $firstName, $lastName);
			
			$this->_returnFeedback(BASE_MSG_SUCCESS, "Der User wurde erfolgreich angelegt");
		} catch(Mpm_Exception $e){
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

}
