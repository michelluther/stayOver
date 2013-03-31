<?php 
class Authorization_model extends CI_Model{

	public function __construct(){
		SO_User::setAuthorizationModel($this);
	}
	
	public function getRoles($userID){
		$where = array(	'uname' => $userID);
		$returnArray = array();
		
		$this->db->from('sec_role_user_assignments');
		$this->db->join('sec_role_content_assignments', 
						'sec_role_user_assignments.role_id = sec_role_content_assignments.role_id');
		$this->db->join('sec_roles',
						'sec_role_user_assignments.role_id = sec_roles.role_id');
		$this->db->join('sec_role_content',
						'sec_role_content_assignments.content_id = sec_role_content.id');
		$this->db->where($where);
		$query = $this->db->get();
		$role_assignments = $query->result();
		foreach ($role_assignments as $role_assignment) {
			$where = array('role_id' => $role_assignment->role_id);
			$query = $this->db->get_where('sec_roles', $where);
			$roleArray = $query->result();
			$role = $roleArray[0];
			$returnArray[$role->role_id] = new SecRole($role->role_id);
		}
		return $returnArray;
	}
	
	public function assignRole(SO_User $user, SecRole $role){
		$data = array('uname' => $user->getID(),
					  'role_id' => $role->getID() );
		$query = $this->db->insert('sec_role_user_assignments', $data);
		if($query == false){
			throw new Mpm_Exception('Fehler beim Zuweisen der Rolle.');
		}
	}
}