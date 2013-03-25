<?php

class SecAuthorizations {
	
	public static function checkActivity(SO_User $user, $activity){
		$return = false;
		foreach ($user->getRoles() as $role) {
			if($role->checkActivity() == true){
				$return = true;
			}
		}
		return $return;
	}
}

class SecRole {
	
	protected $id;
	protected $activities = array();
	
	public function __construct($id, $activities){
		$this->id = $id;
		$this->activities = $activities;		
	}
	
	public function checkActivity($activity){
		$return = false;
		foreach ($this->activities as $currentActivity) {
			if($currentActivity == $activity){
				$return = true;
			}
		}
		return $return;
	}
	
	public function getID(){
		return $this->id;
	}
}

