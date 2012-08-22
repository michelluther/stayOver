<?php

class SO_User{

	private static $instance;
	private static $userModel;
	private static $personModel;

	public $uname;
	private $person;
	public $roles = array();
	public $navigation;

	public static function setUserModel($model){
		self::$userModel = $model;
	}

	public static function setPersonModel($model){
		self::$personModel = $model;
	}

	public static function getInstance($uname){
		if (!isset(self::$instance)){
			if($uname == null){
				throw new Mpm_Exception('No username passed and no user initialized');
			} else {
				self::$instance = new SO_User($uname);
			}
		}
		return self::$instance;
	}

	private function __construct($uname){
		$this->uname = $uname;
		$this->init();
		return $this;
	}

	public function hasRole($role){
		$hasRole = false;
		foreach ($this->roles as $currentRole) {
			if ($role == $currentRole) {
				$hasRole = true;
			};
		}
		return $hasRole;
	}
	
	public function getAssignedPerson(){
		return $this->person;
	}

	public function setAssignedPerson($person){
		$this->person = $person;
	}

	private function init(){
		self::$userModel->setRoles($this);
		self::$personModel->getPersonByUser($this);
	}

}