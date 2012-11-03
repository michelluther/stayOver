<?php

abstract class SO_DateBase extends SO_JSONData implements IF_BASE_NAMED_OBJECT{
	// Model is injected ...
	protected static $model;
	protected $id;
	protected $title;
	protected $beginDate;
	protected $beginTime;
	protected $endDate;
	protected $endTime;
	protected $note;
	protected $helper;
	protected $kids = array();
	protected $isPersistent = false;
	protected $isChanged = true;

	public function __construct($id = null){
		if($id != null){
			$this->id = $id;
		}
	}
	public static function setModel($model){
		self::$model = $model;
	}
	
	//IF_BASE_NAMED_OBJECT
	public function getType(){
		return BASE_OBJECT_TYPE_DATE;		
	}
	
	public function getID(){
		return $this->id;
	}
	
	public function getName(){
		return $this->title;
	}

	public function save(){
		if ($this->id != null){
			self::$model->updateDate($this);
		} else {
			self::$model->insertDate($this);
		}
		$this->isPersistent = true;
		$this->isChanged = false;
		SO_DateFactory::cacheDate($this);
	}
	
	public function delete(){
		self::$model->deleteDate($this);
	}
	
	protected function setPersistent($persistent){
		$this->isPersistent = $persistent;
	}

	// Begin Setters
	public function setId($id){
		if ($this->id == null) {
			$this->id = $id;
		} else {
			throw new Mpm_Exception('Die ID eines Termins kann nicht ge&auml;ndert werden.');			
		}
	}
	
	public function setTitle($title){
		$this->title = $title;
		$this->isChanged = true;
	}

	public function setBeginDate($beginDate){
		$this->beginDate = $beginDate;
		$this->isChanged = true;
	}

	public function setEndDate($endDate){
		$this->endDate = $endDate;
		$this->isChanged = true;
	}

	public function setBeginTime($beginTime){
		$this->beginTime = $beginTime;
		$this->isChanged = true;
	}

	public function setEndTime($endTime){
		$this->endTime = $endTime;
		$this->isChanged = true;
	}

	public function setNote($note){
		$this->note = $note;
		$this->isChanged = true;
	}

	// End Setters
	// Begin Getters

	

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

	public function getChildren($child){
		return $this->children;
	}
	// End Getters
}


