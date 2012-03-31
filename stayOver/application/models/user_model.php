<?php

// include_once 'classes/userdata.php';
include_once 'classes/mpm_exception.php';

class User_model extends CI_Model{

	private $uname;
	private $user;

	/*
	 * Login Procedure
	 */
	public function login($credentials){
		$this->uname = $credentials['uname'];
		$salt = $this->_get_salt();
		$this->_check_hashed_pw($credentials['pw'], $salt);
		$this->get_user_for_uname($this->uname);
		return $this->user;
	}

	private function _get_salt(){
		$this->db->select('salt')->from('tts_users')->where('uname', $this->uname);
		$query = $this->db->get();
		if(count($query->result()) == 0){
			throw new MPM_Exception('Benutzername oder Passwort falsch');
		}
		foreach ($query->result() as $row) {
			$salt = $row->salt;
		}
		return $salt;
	}

	private function _check_hashed_pw($pw, $salt){
		$pw_hashed = md5($pw . $salt);
		$where = array(	'uname' 	=> $this->uname,
					   	'password'	=> $pw_hashed);
		$query = $this->db->get_where('tts_users', $where);
		if(count($query->result()) == 0){
			throw new MPM_Exception('Benutzername oder Passwort falsch');
		}
	}

	/*
	 * Init user data for logged in user
	 */
	
	public function get_user_for_uname($uname){
		$this->uname = $uname;
		$this->user = $this->mpm_user->get_user($this->uname);
		$this->_init_user_data();
		return $this->user;
	}
	
	/*
	 * Initialization, user roles, etc.
	 */

	private function _init_user_data(){
		$this->_set_roles();
	}

	private function _set_pernr(){
		$where = array(	'uname' => $this->uname);
		$query = $this->db->get_where('tts_people', $where);
		$hitlist = $query->result();
		$user_data = $hitlist[0];
		$this->user->personal_id = $user_data->pernr;
	}

	private function _set_roles(){
		$where = array(	'uname' => $this->uname);
		$query = $this->db->get_where('tts_role_user_assignments', $where);
		$role_assignments = $query->result();
		foreach ($role_assignments as $role_assignment) {
			$where = array('role_id' => $role_assignment->role_id);
			$query = $this->db->get_where('tts_roles', $where);
			$roleArray = $query->result();
			$role = $roleArray[0];
			array_push($this->user->roles, $role);
		}
	}

}