<?php

include_once 'application/models/interfaces/So_Interfaces.php';
include_once 'application/models/classes/SEC_Authorizations.php';

class SO_User implements IF_BASE_NAMED_OBJECT, IF_BASE_SAVEABLE{

	static private $instance = null;
	private static $userModel;
	private static $authorizationModel;
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

	public static function setAuthorizationModel($model){
		self::$authorizationModel = $model;
	}
	
	// Creator
	public static function createUser($uname, $pw, $email, $firstName, $lastName){
		self::$userModel->createUser($uname, $pw, $email);
		$user = new SO_User($uname);
		$person = SO_PeopleFactory::createPerson($firstName, $lastName);
		$person->assignUser($user);
		$user->setPerson($person);
		$user->assignRole(new SecRole(ROLE_PARENT));
		if($person->save() != true){
			throw new Mpm_Exception('Fehler beim Anlegen der Person');
		}
		return $user;
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
	
	public static function getUserAdmin($uname){
		$currentUser = SO_User::getInstance();
		if(!$currentUser->hasRole(ROLE_ADMIN)){
			throw new Mpm_Exception("Du bist kein Administrator");
		}
		$user = new SO_User($uname);
		return $user;
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
		$this->roles = self::$authorizationModel->getRoles($this->uname);
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

	public function unlock(){
		self::$userModel->unlockUser($this);
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

	public function changePassword($oldPassword, $newPassword){
		self::$userModel->changeUserPassword($this, $oldPassword, $newPassword);
	}

	public function hasRole($role){
		$hasRole = false;
		foreach ($this->roles as $currentRole) {
			if ($role == $currentRole->getID()) {
				$hasRole = true;
			};
		}
		return $hasRole;
	}

	public function assignRole($role){
		if(!$this->hasRole($role)){
			self::$authorizationModel->assignRole($this, $role);
		}
	}

	public function getRoles(){
		return $this->roles;
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
		if($this->hasRole(ROLE_PARENT)){
			return $this->parent;
		} else {
			return null;
		}
	}

	public function addHelper(){
		if($this->hasRole(ROLE_HELPER)){
			$this->helper = new SO_Helper($this->person);
		}
	}
	
	public function resetPassword($newPassword){
		$currentUser = SO_User::getInstance();
		if(!$currentUser->hasRole(ROLE_ADMIN)){
			throw new Mpm_Exception("Du bist kein Administrator");
		}
		self::$userModel->changeUserPasswordAdmin($this, $newPassword);
	}
	
	public static function requestPasswordReset($email){
		$token = self::$userModel->createPasswordResetToken($email);
		return $token;
	}
	
	public static function resetPasswordViaToken($email, $token, $pw){
		self::$userModel->resetPasswordViaToken($email, $token, $pw);
	}

	public function getHelper(){
		return $this->helper;
	}
}