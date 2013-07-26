<?php
include_once "classes/Base_registration.php";

class Registration_model extends CI_Model{
	
	public function __construct(){
		Base_Registration::setModel($this);
	}
	
	public function saveRegistration(Base_Registration &$registration){
		$registrationKey = $this->_createRegistrationKey();
		$data = array(	'email' => $registration->getEmail(),
						'child_id' => $registration->getAssociatedChild()->getID(),
						'registration_key' => $registrationKey);
		$this->db->insert('base_registration', $data);
		$registration->setRegistrationKey($registrationKey);
	}
	
	public function verifyRegistrationKey($registrationKey, $emailAddress){
		$where = array(	'email' => $emailAddress,
						'registration_key' => $registrationKey );
		$this->db->where($where);
		$query = $this->db->get('base_registration');
		$child = null;
		if(count($query->result()) == 0){
			throw new Mpm_Exception("Der Registrierungsschl&uuml;ssel ist nicht f&uuml;r diese E-Mailadresse registriert.");
		} else {
			foreach ($query->result() as $entry) {
				$childID = $entry->child_id;
				$childPerson = SO_PeopleFactory::getPerson($childID);
				$child = new SO_Child($childPerson);
			}
		}
		return $child;
	}

	private function _createRegistrationKey(){
		$registrationKey = md5(mt_rand());
		return $registrationKey;
	}
}