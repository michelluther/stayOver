<?php

abstract class SO_DateBase extends SO_JSONData {
	private $title;
	private $beginDate;
	private $endDate;
	private $beginTime;
	private $endTime;
	private $note;
	private $children = array();
	private $helper = array();
	private $isPersistent;
	private $isChanged;
	
	public function __construct($id){
		SO_ModelInterface::$terminModel->getDateFromDB($id);
		$this->beginDate = $beginDate;
		$this->endDate = $endDate;
		$this->beginTime = $beginTime;
		$this->endTime = $endTime;
		$this->child = SO_PeopleFactory::getPerson($childID);
	}
	
	public function save(){
		SO_ModelInterface::$terminModel->saveDate($this);
	}
	
	public function setPersistent($persistent){
		$this->isPersistent = $persistent;
	}
	
	// Setter
	public function setTitle($title){
		$this->title = $title;
	}
	
	public function setBeginDate($beginDate){
		$this->beginDate = $beginDate;
	}
	
	public function setEndDate($endDate){
		$this->endDate = $endDate;
	}
	
	public function setBeginTime($beginTime){
		$this->beginTime = $beginTime;
	}
	
	public function setEndTime($endTime){
		$this->endTime = $endTime;
	}
	
	public function setNote($note){
		$this->note = $note;
	}
	
	public function addChild($child){
		array_push($this->children, $child);	
	}
	
	// Getter
	public function getTitle($title){
		return $this->title;
	}
	
	public function getBeginDate($beginDate){
		return $this->beginDate;
	}
	
	public function getEndDate($endDate){
		return $this->endDate;
	}
	
	public function getBeginTime($beginTime){
		return $this->beginTime;
	}
	
	public function getEndTime($endTime){
		return $this->endTime;
	}
		
	public function getNote($note){
		return $this->note;
	}
}


