<?php

include_once 'classes/So_userdata.php';
include_once 'classes/mpm_exception.php';
include_once "classes/Base_registration.php";

class User_model extends CI_Model{

	public function __construct(){
		SO_User::setUserModel($this);
		Base_Registration::setUserModel($this);
	}

	/*
	 * User Management
	*/
	public function createUser($uname, $pw, $email){
		$pw_array = $this->_create_hash_array($pw);
		if(!$this->_validateEmail($email)){
			throw new Mpm_Exception('Die Emailadresse ist nicht g&uuml;ltig.');
		}
		$user_data = array(	'uname' => $uname,
							'password' => $pw_array['pw_hash'],
							'salt'	=> $pw_array['salt'],
							'email' => $email );
		$result = $this->db->insert('base_users', $user_data);
		if ($result == false){
			throw new Exception('User konnte nicht angelegt werden');
		}
	}

	private function _create_hash_array($pw){
		$salt = mt_rand();
		$hash = md5($pw . $salt);
		$security_data = array( 'pw_hash' => $hash,
								'salt'	=> $salt );
		return $security_data;
	}

	/*
	 * Login Procedure
	*/
	public function login($uname, $pw){
		$this->_checkIfUserLocked($uname);
		$salt = $this->_get_salt($uname);
		$this->_check_hashed_pw($uname, $pw, $salt);
		return true;
	}

	private function _checkIfUserLocked($uname){
		$this->db->where(array( 'uname' => $uname,
				'locked' => true ));
		$query = $this->db->get('base_users');
		if(count($query->result()) > 0){
			throw new Mpm_Exception('Benutzer ist gesperrt');
		}
	}

	private function _get_salt($uname){
		$this->db->select('salt')->from('base_users')->where('uname', $uname);
		$query = $this->db->get();
		if(count($query->result()) == 0){
			throw new MPM_Exception('Benutzername oder Passwort falsch');
		}
		foreach ($query->result() as $row) {
			$salt = $row->salt;
		}
		return $salt;
	}

	private function _check_hashed_pw($uname, $pw, $salt){
		$pw_hashed = md5($pw . $salt);
		$where = array(	'uname' 	=> $uname,
				'password'	=> $pw_hashed);
		$query = $this->db->get_where('base_users', $where);
		if(count($query->result()) > 0){
			$this->_resetFailedAttampts($uname);
		} else {
			$this->_increaseFailedAttempts($uname);
			throw new MPM_Exception('Benutzername oder Passwort falsch');
		}
	}

	private function _increaseFailedAttempts($uname){
		$where = array(	'uname' 	=> $uname);
		$this->db->select('failed_attempts');
		$query = $this->db->get_where('base_users', $where);
		foreach ($query->result() as $row) {
			$failedAttempts = $row->failed_attempts;
		}
		$failedAttempts ++;
		$data = array('failed_attempts' => $failedAttempts);
		$this->db->where($where);
		$this->db->update('base_users', $data);
		if($failedAttempts >= 3){
			$this->_lockUser($uname);
		}
	}

	private function _resetFailedAttampts($uname){
		$where = array(	'uname' 	=> $uname);
		$data = array('failed_attempts' => 0);
		$this->db->where($where);
		$this->db->update('base_users', $data);
	}

	private function _lockUser($uname){
		$this->db->where(array( 'uname' => $uname,
								'locked' => false ));
		$data = array('locked' => true );
		$this->db->update('base_users', $data);
	}

	public function updateUserData(SO_User $user){
		// Currently, only the email-address, other (like name and so on) is saved via Person model
		$changesMade = false;
		if(!$this->_validateEmail($user->getEmail())){
			throw new Mpm_Exception('Die Emailadresse ist nicht g&uuml;ltig.');
		}
		$data = array(	'uname' => $user->getID(),
						'email' => $user->getEmail());
		$query = $this->db->get_where('base_users', $data);
		if(count($query->result()) == 0){
			$this->db->where(array( 'uname' => $user->getID()));
			$this->db->update('base_users', $data);
			if($this->db->_error_message() != null){
				throw new Mpm_Exception($this->db->_error_message());
			} else {
				$changesMade = true;
			}
		}
		return $changesMade;
	}

	public function unlockUser(SO_User $user){
		$currentUser = SO_User::getInstance();
		if(!$currentUser->hasRole(ROLE_ADMIN)){
			throw new Mpm_Exception("Das darf nur ein Administrator");
		}
		$changesMade = false;
		$this->db->where(array( 'uname' => $user->getID(),
								'locked' => true ));
		$data = array('locked' => false );
		$this->db->update('base_users', $data);
	}

	public function changeUserPassword(SO_User $user, $old_pw, $new_pw){
		if($this->login($user->getID(), $old_pw) == true){
			$userName = $user->getID();
			$this->_setPW($userName, $new_pw);
		} else {
			throw new Mpm_Exception('Benutzername falsch');
		}
	}

	public function changeUserPasswordAdmin(SO_User $user, $new_pw){
		$currentUser = SO_User::getInstance();
		if(!$currentUser->hasRole(ROLE_ADMIN)){
			throw new Mpm_Exception("Du bist kein Administrator");
		} else {
			$userName = $user->getID();
			$this->_setPW($userName, $new_pw);
		}
	}
	
	public function createPasswordResetToken($email){
		$passwordResetToken = md5(mt_rand());
		if(!$this->_validateEmail($email)){
			throw new Mpm_Exception('Die Emailadresse ist nicht g&uuml;ltig.');
		}
		$data = array(	'email' => $email,
						'token'	=> $passwordResetToken);
		$this->db->where(array('email' => $email));
		$query = $this->db->insert('base_pw_reset', $data);
		return $passwordResetToken;
	}
	
	public function resetPasswordViaToken($email, $token, $pw){
		if($this->_validatePasswordResetToken($email, $token)){
			$userName = $this->getUserNameForEmail($email);
			$this->_setPW($userName, $pw);
		} else {
			throw new Mpm_Exception("Der Token ist nicht g&uuml;ltig.");
		}
	}
	
	private function _validatePasswordResetToken($email, $passwordResetToken){
		$where = array(	'email' => $email,
						'token' => $passwordResetToken );
		$this->db->where($where);
		$query = $this->db->get('base_pw_reset');
		if(count($query->result()) == 1){
			return true;
		} else {
			return false;
		}	
	}
	
	private function _setPW($userName, $pw){
		$pw_array = $this->_create_hash_array($pw);
		$this->db->where(array('uname' => $userName));
		$data = array('password' => $pw_array['pw_hash'],
				'salt'	 => $pw_array['salt'] );
		$this->db->update('base_users', $data);
	}

	private function _set_pernr(){
		$where = array(	'uname' => $this->uname);
		$query = $this->db->get_where('base_people', $where);
		$hitlist = $query->result();
		$user_data = $hitlist[0];
		$this->user->personal_id = $user_data->pernr;
	}

	/*
	 * Getters
	*/

	public function getEmail(IF_BASE_NAMED_OBJECT $user){
		$where = array('uname' => $user->getID());
		$this->db->where($where);
		$this->db->select('email');
		$query = $this->db->get('base_users');
		$userEmails = $query->result();
		$userEmail = $userEmails[0]->email;
		return $userEmail;
	}
	
	public function getUserNameForEmail($emailAddress){
		$this->db->where(array('email' => $emailAddress));
		$this->db->select('uname');
		$query = $this->db->get('base_users');
		$uname = null;
		if(count($query->result()) != 0){
			foreach ($query->result() as $unameFound) {
				$uname = $unameFound->uname;
			}
		}
		return $uname;
	}
	
	private function _validateEmail($email){
		return filter_var($email, FILTER_VALIDATE_EMAIL);
	}

}