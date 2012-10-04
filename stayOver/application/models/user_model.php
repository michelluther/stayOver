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


	private function _set_pernr(){
		$where = array(	'uname' => $this->uname);
		$query = $this->db->get_where('base_people', $where);
		$hitlist = $query->result();
		$user_data = $hitlist[0];
		$this->user->personal_id = $user_data->pernr;
	}

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
	
}