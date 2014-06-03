<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'so_base_controller.php';

class Registration extends SO_BaseController{

	public function __construct(){
		parent::__construct();
		$this->load->model('Registration_model');
	}

	public function index(){
		try {
			$this->content['view'] = 'register';
			$this->content['data'] = null;
			$this->navigation['view'] = null;
			$this->banner['view'] = null;
			$this->footer['view'] = null;
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
				$this->_setCookieUserGeneration($registrationKey);
				$this->_returnFeedback(BASE_MSG_SUCCESS, "Registrierungsschl&uumlssel wurde erkannt");
			}
			// 			$this->_callView();
			
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
			$uname = $_POST['user']['uname'];
			$pw	= $_POST['user']['pw'];
			if ($pw != $_POST['user']['pw_repeat']){
				throw new Mpm_Exception('Passwort nicht zwei mal gleich');
			}
			$email = $_POST['user']['email'];
			$firstName = $_POST['user']['firstName'];
			$lastName = $_POST['user']['lastName'];
			$this->_clear_session();
			$user = SO_User::createUser($uname, $pw, $email, $firstName, $lastName);
			SO_User::login($uname, $pw);
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