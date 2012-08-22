<?php

include_once 'classes/So_userdata.php';
include_once 'classes/mpm_exception.php';

class User_model extends CI_Model{

	private $uname;
	private $user;

	public function __construct(){
		SO_User::setUserModel($this);
	}
	
	/*
	 * Login Procedure
	 */
	public function login($credentials){
		$this->uname = $credentials['uname'];
		$salt = $this->_get_salt();
		$this->_check_hashed_pw($credentials['pw'], $salt);
		return true;
	}

	private function _get_salt(){
		$this->db->select('salt')->from('base_users')->where('uname', $this->uname);
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
		$query = $this->db->get_where('base_users', $where);
		if(count($query->result()) == 0){
			throw new MPM_Exception('Benutzername oder Passwort falsch');
		}
	}

	/*
	 * Init user data for logged in user
	 */
	
	/*
	 * Initialization, user roles, etc.
	 */

	private function _init_user_data(){
		$this->_set_roles();
	}

	private function _set_pernr(){
		$where = array(	'uname' => $this->uname);
		$query = $this->db->get_where('base_people', $where);
		$hitlist = $query->result();
		$user_data = $hitlist[0];
		$this->user->personal_id = $user_data->pernr;
	}

	public function setRoles(SO_User &$user){
		$where = array(	'uname' => $user->uname);
		$query = $this->db->get_where('sec_role_user_assignments', $where);
		$role_assignments = $query->result();
		foreach ($role_assignments as $role_assignment) {
			$where = array('role_id' => $role_assignment->role_id);
			$query = $this->db->get_where('sec_roles', $where);
			$roleArray = $query->result();
			$role = $roleArray[0];
			array_push($user->roles, $role);
		}
	}
	
}