<?php

class Mpm_Exception extends Exception{
	
	private $fault_view;
	private $fault_data;
	
	public function __construct($message = null, $code = 0, $fault_view = null, $fault_data = null){
		parent::__construct($message, $code);
		$this->fault_view = $fault_view;
		$this->fault_data = $fault_data;
	}
	
	public function get_fault_view(){
		return $this->fault_view;
	}
	
	public function get_fault_data(){
		return $this->fault_data;
	}
	
}