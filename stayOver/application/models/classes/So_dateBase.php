<?php

abstract class SO_DateBase extends SO_JSONData {
	// Model is injected
	private static $model;
	
	private $title;
	private $beginDate;
	private $beginTime;
	private $endDate;
	private $endTime;
	private $note;
	private $children = array();
	private $helper = array();
	private $isPersistent;
	private $isChanged;
	
	public function __construct($id = null){
		if($id != null){
			$this->id = $id;
		}
	}
	
	public static function setModel($model){
		self::$model = $model;
	}
	
	public function init(){
		$this->model->initData($this);
	}
	
	public function save(){
		$this->model->saveDate($this);
	}
	
	private function setPersistent($persistent){
		$this->isPersistent = $persistent;
	}
	
	// Begin Setters
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
	// End Setters
	// Begin Getters
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
	// End Getters
}


