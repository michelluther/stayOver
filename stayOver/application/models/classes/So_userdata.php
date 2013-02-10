<?php

include_once 'application/models/interfaces/So_Interfaces.php';

class SO_User implements IF_BASE_NAMED_OBJECT, IF_BASE_SAVEABLE{

	static private $instance = null;
	private static $userModel;
	private static $personModel;

	private $uname;
	private $email;
	private $person;
	private $parent;
	private $helper;
	private $is_persistent;

	public $roles = array();
	public $navigation;

	// Models
	public static function setUserModel($model){
		self::$userModel = $model;
	}
	
	public static function setPersonModel($model){
		self::$personModel = $model;
	}

	// Singleton
	public static function getInstance(){
		if (!isset(self::$instance)){
			throw new Mpm_Exception('No username passed and no user initialized');
		}
		return self::$instance;
	}

	private static function setInstance($uname){
		self::$instance = new self($uname);
		$instance = new self($uname);
		self::$instance->init();
	}
	
	// Begin of Object
	private function __construct($uname){
		$this->uname = $uname;
	}
	
	// IF_BASE_NAMED_OBJECT
	public function getType(){
		return BASE_OBJECT_TYPE_USER;
	}
	
	public function getID(){
		return $this->uname;
	}
	
	public function getName(){
		return $this->person->getName();
	}
	
	// IF_BASE_SAVEABLE
	public function save(){
		$changesMade = false;
		$changesUser = self::$userModel->updateUserData($this);
		$changesPerson = self::$personModel->updatePersonalData($this->person);
		if($changesPerson == true || $changesUser == true){
			$changesMade = true;
		} 
		return $changesMade;
	}
	
	public function getFirstName(){
		return $this->person->getFirstName();
	}
	
	public function getLastName(){
		return $this->person->getLastName();
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	private function init(){
		$this->roles = self::$userModel->getRoles($this->uname);
		$this->person = SO_PeopleFactory::getPersonByUser($this);
		$this->setEmail(self::$userModel->getEmail($this));
		$this->addParent();
		$this->addHelper();
	}
	
	public static function login($uname, $pw){
		if(self::$userModel->login($uname, $pw)){
			self::setInstance($uname);
		} else {
			throw Mpm_Exception('Benutzername oder Passwort falsch');
		}
	}

	public function setEmail($email){
		$this->email = $email;
	}
	
	public function setFirstName($firstName){
		$this->person->setFirstName($firstName);
	}
	
	public function setLastName($lastName){
		$this->person->setLastName($lastName);
	}
	
	public static function getLoggedInUser($uname, $sessionID){
		/* TODO: Verification of session id */
		self::setInstance($uname);
		return self::$instance;
	}

	public function hasRole($role){
		$hasRole = false;
		foreach ($this->roles as $currentRole) {
			if ($role == $currentRole->role_id) {
				$hasRole = true;
			};
		}
		return $hasRole;
	}
	
	public function setPerson($person){
		$this->person = $person;
	}

	private function addParent(){
		if ($this->hasRole(ROLE_PARENT)){
			$this->parent = new SO_Parent($this->person);
		}
	}

	public function getParent(){
		return $this->parent;
	}

	public function addHelper(){
		if($this->hasRole(ROLE_HELPER)){
			$this->helper = new SO_Helper($this->person);
		}
	}
	
	public function getHelper(){
		return $this->helper;
	}
}