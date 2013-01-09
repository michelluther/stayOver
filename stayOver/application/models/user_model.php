<?php

include_once 'classes/So_userdata.php';
include_once 'classes/mpm_exception.php';

class User_model extends CI_Model{

	public function __construct(){
		SO_User::setUserModel($this);
	}
		
	/*
	 * Login Procedure
	 */
	public function login($uname, $pw){
		$salt = $this->_get_salt($uname);
		$this->_check_hashed_pw($uname, $pw, $salt);
		return true;
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
		$this->db->where = $where;
		$this->db->update('base_users', $data);
	}
	
	private function _resetFailedAttampts($uname){
		$where = array(	'uname' 	=> $uname);
		$data = array('failed_attempts' => 0);
		$this->db->where = $where;
		$this->db->update('base_users', $data);
	}
	
	/*
	 * Init user data for logged in user
	 */
	public function updateUserData(SO_User $user){
		// Currently, only the email-address, other (like name and so on) is saved via Person model
		$changesMade = false;
		$data = array('uname' => $user->getID(),
									'email' => $user->getEmail());
		$query = $this->db->get_where('base_users', $data);
		if(count($query->result()) == 0){
			$this->db->where = array( 'uname' => $user->getID());
			$this->db->update('base_users', $data);
			if($this->db->_error_message() != null){
				throw new Mpm_Exception($this->db->_error_message());
			} else {
				$changesMade = true;
			}
		} 
		return $changesMade;
	}

	public function changeUserPassword($pw){
		/* TODO: Change User Password in Model */		
	}
	
	private function _set_pernr(){
		$where = array(	'uname' => $this->uname);
		$query = $this->db->get_where('base_people', $where);
		$hitlist = $query->result();
		$user_data = $hitlist[0];
		$this->user->personal_id = $user_data->pernr;
	}
	
	/*
	* Initialization, user roles, etc.
	*/
	public function getRoles($userID){
		$where = array(	'uname' => $userID);
		$returnArray = array();
		$query = $this->db->get_where('sec_role_user_assignments', $where);
		$role_assignments = $query->result();
		foreach ($role_assignments as $role_assignment) {
			$where = array('role_id' => $role_assignment->role_id);
			$query = $this->db->get_where('sec_roles', $where);
			$roleArray = $query->result();
			$role = $roleArray[0];
			$returnArray[$role->role_id] = $role;
		}
		return $returnArray;
	}
	
	public function getEmail(IF_BASE_NAMED_OBJECT $user){
		$where = array('uname' => $user->getID());
		$this->db->where($where);
		$this->db->select('email');
		$query = $this->db->get('base_users');
		$userEmails = $query->result();
		$userEmail = $userEmails[0]->email;
		return $userEmail;
	}
	
}