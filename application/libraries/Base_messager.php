<?php

require_once 'application/models/interfaces/Mpm_jsondata.php';

define("BASE_MSG_SUCCESS", 'success');
define("BASE_MSG_ERROR", 'error');

class Base_Messager {
	
	public function get_message($msgClass, $msgText){
		return new Base_Message($msgClass, $msgText);
	}
}

class Base_Message implements MPM_JSONData{
	
public $msgClass;
public $msgText;

public function __construct($msgClass, $text){
	$this->msgClass = $msgClass;
	$this->msgText = $text;
}

public function getJSONableData(){
	return get_object_vars($this);
}
}