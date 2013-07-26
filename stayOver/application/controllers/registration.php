<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'so_base_controller.php';

class Registration extends SO_BaseController{

	public function __construct(){
		parent::__construct();
		$this->load->model('Registration_model');
	}

	public function register(){
		try {
			$this->content['view'] = 'register';
			$this->content['data'] = null;
			$this->navigation['view'] = null;
			$this->banner['view'] = null;
			$this->_callView();
		} catch (Exception $e) {
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function submitRegistrationKey(){
		try {
			$registrationKey = $_POST['registration']['key'];
			$email = $_POST['registration']['email'];
			$invitation = Base_Registration::verifyRegistration($email, $registrationKey);
			$userID = $invitation->getAssociatedUser();
			if($userID == null){
				$this->_setCookieUserGeneration();
			}
			// 			$this->_callView();
			$this->_returnFeedback(BASE_MSG_SUCCESS, "Ich w&uuml;rde Dir jetzt auch echt einen anlegen...");
		} catch (Mpm_Exception $e) {
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}
	
	public function userSetupForm(){
		try {
			$this->_validateUserGenerationKey();
			$this->content['view'] = 'createOwnUser';
			$this->content['data'] = null;
			$this->navigation['view'] = null;
			$this->banner['view'] = null;
			$this->_callView();
		} catch (Exception $e) {
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
		
	}

	public function submitUserRegistration(){
		try {
			$this->_validateUserGenerationKey();
			$this->_returnFeedback(BASE_MSG_SUCCESS, "Der Benutzer wurde erfolgreich angelegt, viel Spa&szlig;!!");
		} catch (Exception $e) {
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	private function _setCookieUserGeneration($registrationKey){
		$this->session->set_userdata('userGenerationKey', md5(mt_rand()));
		$this->session->set_userdata('registrationKey', $registrationKey);
	}

	private function _validateUserGenerationKey(){
		if(!isset($this->session->userdata['userGenerationKey'])){
			throw new Mpm_Exception("Fehler beim Anlegen des Benutzers");
		}
	}
}