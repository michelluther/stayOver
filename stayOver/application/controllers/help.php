<?php
/**
 * @author michel
 *
 */

include_once 'so_base_controller.php';

class Help extends SO_BaseController{

	public function __construct(){
		try {
			parent::__construct();
			if($this->user == null){
				return; // redirect to login done in parent!
			}
		} catch(Mpm_Exception $e){
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function index(){
		$this->content['view'] = 'help';
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

	public function unlockUser(){
		try {
			$uname = $_POST['form']['user']['uname'];
			$user = SO_User::getUserAdmin($uname);
			$user->unlock();
			$this->_returnFeedback(BASE_MSG_SUCCESS, "Der User wurde entsperrt");
		} catch (Mpm_Exception $e) {
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function resetPWAdmin(){
		try{
			$uname = $_POST['form']['user']['uname'];
			$user = SO_User::getUserAdmin($uname);
			$newPassword = $_POST['form']['user']['pw_new'];
			$user->resetPassword($newPassword);
			$this->_returnFeedback(BASE_MSG_SUCCESS, "Das Passwort des Benutzers wurde zurückgesetzt");
		} catch (Mpm_Exception $e) {
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}
		
	
}
