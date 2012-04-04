<?php
class Mpm_calendar{
	
	/* 
	 * Internally we work with date-objects, but user specific date format
	 * is used when passing dates out to the frontend
	 */
	
	private static $calendar;
	private static $db_date_format;
	private static $user_date_format;
	private static $locale;
	
	public function __construct(){
		$CI =& get_instance();
		self::$db_date_format = $CI->config->config['db_date_format'];	
		self::$user_date_format = $CI->config->config['user_date_format'];
	}
	
	public static function get_date_from_db_string($date_string){
		$date = DateTime::createFromFormat(self::$db_date_format, $date_string);
		return $date;
	}
	
	public static function get_date_from_user_string($date_string){
		$date = DateTime::createFromFormat(self::$user_date_format, $date_string);
		return $date;
	}
	
	public static function get_date_from_string($date_string, $date_format){
		$date = DateTime::createFromFormat($date_format, $date_string);
		return $date;
	}
	
	public static function add_to_date(&$dateTime, $dateInterval){
		$dateTime->add($dateInterval);
	}
	
	public static function subtract_from_date(&$dateTime, $dateInterval){
		$dateTime->sub($dateInterval);
	}
	
	public static function format_date_for_DataBase($dateTime){
		return $returnString = $dateTime->format(self::$db_date_format);
	}
	
	public static function format_date_for_User($dateTime){
		return $returnString = $dateTime->format(self::$user_date_format);
	}
	
	public static function get_week_day($dateTime){
		return $dateTime->format('D');
	}
	
	public static function get_calendar_days($start_date_string, $end_date_string){
		$dateArray = array();
		$start_date= strtotime($start_date_string);
		$end_date = strtotime($end_date_string); 
		if ($start_date >= $end_date){
			throw new MPM_Exception('Beginndatum ist nicht kleiner Endedatum');
		}
		$date_iterator = $start_date;
		while ($date_iterator <= $end_date) {
			$dateObject = new Mpm_calendar_entry(self::$user_date_format, $date_iterator);
			$dateArray[$dateObject->getDate()] = $dateObject;
			$date_iterator = strtotime("+1 day", $date_iterator);
		} 
		return $dateArray;
	}
	
	public static function getStringIntervalFromNow($past, $future){
		/*
		 * Past & Future als Intervallangabe,
		* 	z.B: 	P2M -> 2 Monate
		* 			  P1W -> 1 Woche
		*  Retourniert ein Array Beginndatum, Endedatum
		*/
		$today = new DateTime();
		$beginDate = clone $today;
		self::subtract_from_date($beginDate, new DateInterval($past)); // z.B
		$beginDateString = self::format_date_for_DataBase($beginDate);
		$endDate = clone $today;
		self::add_to_date($endDate, new DateInterval($future));
		$endDateString = self::format_date_for_DataBase($endDate);
		return array('beginDate' => $beginDateString,
					 			 'endDate'   => $endDateString);
	}
}

class Mpm_calendar_object{
	
	public function __construct(){
		return $this;
	}
}

class Mpm_calendar_entry{
	
	private $dateString;
	private $date;
	private $hours;
	
	public function __construct($format, $date){
		$this->setDate($date, $format);
		return $this;
	}
	
	private function setDate($date, $format) {
		$this->date = $date;
		$this->dateString = date($format, $date);
	}
	
	public function getDateString(){
		return $this->dateString;
	}
	
	public function getDate(){
		return $this->date;
	}
}