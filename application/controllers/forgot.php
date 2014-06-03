<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'so_base_controller.php';

class Forgot extends SO_BaseController{
	public function __construct(){
		parent::__construct();
	}
	// Date Management
	public function index(){
		$this->content['view'] = 'resetPassword';
		$this->content['data'] = null;
		$this->navigation['view'] = null;
		$this->banner['view'] = null;
		$this->footer = null;
		$this->_callView();
	}

	public function submitResetRequest(){
		$email = $_POST['form']['pw_reset']['email'];
		$passwordResetToken = SO_User::requestPasswordReset($email);
		$this->email->clear();
		$this->email->from(BASE_MAIL_FROM, BASE_MAIL_FROM_TEXT);
		$this->email->subject('Passwort&auml;nderung f&uuml; Little\'s Helper' );
		$emailMessage = $this->_setEmailHTMLHeader();
		$emailMessage .= $this->_setEmailHTMLBody('<p>Hallo lieber Benutzer,</p>'
				. '<p>Du hast f&uuml;r Deinen Benutzeraccount bei Little\'s Helper eine Passwortr&uuml;cksetzung beantragt.</p>'
				. '<p>Mit dem folgenden Token kannst Du das Passwort für Deinen Benutzer neu setzen:<br />'
				. $passwordResetToken . '</p>'
				. '<p>Du kannst Dein Passwort <a href="'. base_url() .'/index.php/forgot/enterNewPassword">hier</a> zur&uuml;cksetzen.');
		$emailMessage .= $this->_setEmailHTMLFooter();
		$this->email->message($emailMessage);
		try{
			$this->email->to($email);
	//		$this->email->send();
			$this->_returnFeedback(BASE_MSG_SUCCESS, "Eine Email mit den notwendigen Infos zur Passwortr&uuml;cksetzung wurden Dir zugesendet.");
		} catch (Mpm_Exception $e) {
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function enterNewPassword(){
		$this->content['view'] = 'enterPasswordReset';
		$this->content['data'] = null;
		$this->_callView();
	}
	
	public function resetPassword(){
		try{
			$email = $_POST['form']['pw_reset']['email'];
			$token = $_POST['form']['pw_reset']['token'];
			$new_pw = $_POST['form']['pw_reset']['pw'];
			SO_User::resetPasswordViaToken($email, $token, $new_pw);
			$this->_returnFeedback(BASE_MSG_SUCCESS, 'Dein Passwort wurde ge&auml;ndert. Du kannst Dich nun anmelden.<a href="' . base_url() . '/index.php/stayOver">Zum Login!</a>');
		} catch (Exception $e){
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}
}