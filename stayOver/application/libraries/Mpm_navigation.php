<?php
class Mpm_navigation {
	
	private $navigation;
	
	public function &get_navigation($activities){
		usort($activities, function($a, $b){
			return strcmp($a->index, $b->index);
		});
		if ($this->navigation == null){
			$this->navigation = new MPM_NavigationObject($activities);	
		}
		return $this->navigation;
	}
	
	public function set_active_entry(&$navigation, $activity){
		$navigation->set_active_entry($activity);
	}
}

class MPM_NavigationObject{

	private $navigationEntries = array();

	public function __construct($activities){
		foreach ($activities as $activity) {
			$navigationEntry = new MPM_NavigationEntry($activity);
			$this->navigationEntries[$navigationEntry->get_index()] = $navigationEntry;
		}
		
		return $this;
	}

	public function set_active_entry($activity){
		$activeEntryFound = false;
		foreach ($this->navigationEntries as $navigationEntry) {
			if ($navigationEntry->get_activity() == $activity) {
				$navigationEntry->set_active();
				$activeEntryFound = true;
			} else {
				$navigationEntry->set_inactive();
			}
		}
		// Set default: first Entry
		if($activeEntryFound == false){
			$this->navigationEntries[0]->set_active();
		}
	}
	
	public function get_navigationEntries(){
		return $this->navigationEntries;
	}
	
	private function get_entry_index(&$navigationEntry){
		$index = $navigationEntry->get_index();
		return $index;
	}

}

class MPM_NavigationEntry{

	private $name;
	private $activity;
	private $target;
	private $enabled;
	private $active;
	private $index;
	private $is_active;
	
	public function __construct($activity, $target = null){
		$this->name = $activity->description;
		$this->activity =  $activity->activity;
		$this->target = $target;
		$this->index = $activity->index;
		return $this;
	}

	public function set_active(){
		$this->is_active = true;
	}
	
	public function set_inactive(){
		$this->is_active = false;
	}
	
	public function get_name(){
		return $this->name;
	}

	public function get_activity(){
		return $this->activity;
	}

	public function get_target(){
		return $this->target;
	}
	
	public function get_index(){
		return $this->index;
	}

	public function get_is_active(){
		return $this->is_active;
		//return true;
	}
}
?>