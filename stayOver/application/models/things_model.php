<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// Data base abstraction for dates
require_once 'interfaces/Mpm_jsondata.php';

require_once 'classes/So_jsonData.php';
require_once 'classes/So_thingBase.php';
require_once 'cl	asses/So_thingsFactory.php';

class Things_model extends CI_Model{
	
	public function __construct(){
		SO_ThingsFactory::setModel($this);
	}
	
	public function getThingsForDate(SO_DateBase $date){
		
	}
	
}