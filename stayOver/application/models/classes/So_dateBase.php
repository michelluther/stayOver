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
		self::$model->initData($this);
	}
	
	public function save(){
		self::$model->saveDate($this);
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
	
	public function getId(){
		return $this->id;
	}
	
	public function getTitle(){
		return $this->title;
	}
	
	public function getBeginDate(){
		return $this->beginDate;
	}
	
	public function getEndDate(){
		return $this->endDate;
	}
	
	public function getBeginTime(){
		return $this->beginTime;
	}
	
	public function getEndTime(){
		return $this->endTime;
	}
		
	public function getNote(){
		return $this->note;
	}
	// End Getters
}


