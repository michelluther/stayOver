<?php

class Mpm_authorization{
	
	/*
	 * Constants:
	 * 	Authorizable activities
	 */
	
	const CREATE_USER 	 = 'create_user';
	const MANAGE_PROJECT = 'manage_project';
	
	
	public function check_authorization($user, $action, $target = NULL){
		return true;
		// throw new Exception('Du bist nicht autorisiert');
	}
	
}