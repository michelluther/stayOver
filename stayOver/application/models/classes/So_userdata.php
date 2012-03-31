<?php

class SO_User{

	public $uname;
	public $personal_id;
	public $roles = array();
	public $navigation;

	public function __construct($uname){
		$this->uname = $uname;
		return $this;
	}

}