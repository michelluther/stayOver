<?php

class Mpm_user{

	private $user;
	
	public function get_user($uname){
		if ($this->user == null){
			$this->user = new Mpm_user_object($uname);
		}
		return $this->user;
	}

}


class Mpm_user_object{

	public $uname;
	public $personal_id;
	public $roles = array();
	public $navigation;

	public function __construct($uname){
		$this->uname = $uname;
		return $this;
	}

}