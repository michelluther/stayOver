<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//

class Navigation_model extends CI_Model{

	private $user;
	private $navigation;

	public function init_navigation(&$user){
		$this->user = $user;
		$this->_set_navigation();
		return $this->navigation;
	}

	private function _set_navigation(){
		$activities = array();
		foreach ($this->user->roles as $role) {
			$where = array('role_id' => $role->role_id);
			$this->db->select('*');
			$this->db->from('sec_role_content_assignments');
			$this->db->join('sec_role_content', 'sec_role_content_assignments.content_id = sec_role_content.id', 'inner'); 
			$this->db->where($where);
			$query = $this->db->get();
			$activities_add = $query->result();
			$activities = array_merge($activities, $activities_add);
		}
		$this->navigation = $this->mpm_navigation->get_navigation($activities);
	}


}