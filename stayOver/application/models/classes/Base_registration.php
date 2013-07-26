<?php 
class Base_Registration{

	private static $model;
	private static $userModel;

	private $emailAddress;
	private $uname;
	private $unameRead;
	private $child;
	private $registrationKey;

	public static function setModel($model){
		self::$model = $model;
	}

	public static function setUserModel($model){
		self::$userModel = $model;
	}

	public static function createNewInvitation($email){
		$invitation = new Base_Registration($email);
		return $invitation;
	}

	public static function verifyRegistration($email, $registrationKey){
		$registration = new Base_Registration($email);
		$registration->registrationKey = $registrationKey;
		$registration->_verifyRegistration($registrationKey);
		return $registration;
	}

	private function __construct($emailAddress){
		$this->emailAddress = $emailAddress;
	}
	
	public function setAssociatedChild(SO_Child $child){
		if($this->registrationKey != null){
			throw new Mpm_Exception("Nach Generierung des Registrierungsschlüssels kann kein Kind mehr hinzugefügt werden.");
		}
		$this->child = $child;
	}
	
	public function getEmail(){
		return $this->emailAddress;
	}
	
	public function getAssociatedChild(){
		return $this->child;
	}
	
	public function getAssociatedUser(){
		
	}
	
	public function getRegistrationKey(){
		return $this->registrationKey;
	}
	
	public function setRegistrationKey($registrationKey){
		$this->registrationKey = $registrationKey;
	}
	
	public function save(){
		$this->registrationKey = self::$model->saveRegistration($this);
	}
	
	private function _createInvitiation($emailAddress, $childForInvitation){
		$registrationKey = self::$model->createRegistrationKey($emailAddress, $childForInvitation);
		return $registrationKey;
	}

	private function _verifyRegistration($registrationKey){
		$this->child = self::$model->verifyRegistrationKey($registrationKey, $this->emailAddress);
	}

	private function _getUser($emailAddress){
		if($this->unameRead != true){
			$this->uname = self::getUserNameForEmail($emailAddress);
			$this->unameRead = true;
		}
		return $this->uname;
		
	}
	
	
}