<?php

interface IF_BASE_NAMED_OBJECT{
	public function getType();
	
	public function getID();
	
	public function getName();
}

interface IF_SO_Parent{
	public function getChildren();
	
	public function assignHelperToChild(IF_BASE_NAMED_OBJECT $child, IF_BASE_NAMED_OBJECT $helper);
	
	public function unassignHelperFromChild(IF_BASE_NAMED_OBJECT $child, IF_BASE_NAMED_OBJECT $helper);
	
}

interface IF_SO_Child{
	public function getHelpers(); 	
}

interface IF_SO_Helper{
	public function getChildren();
}

interface IF_SO_Person{
	
	public function getFirstName();
	
	public function getLastName();
	
	public function getBirthday();
}

interface IF_BASE_SAVEABLE{
	public function save();
}