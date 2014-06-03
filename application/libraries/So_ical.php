<?php
class SO_Ical{
	
	// Full statements
	const openingStatement = 'BEGIN:VCALENDAR';
	const prodStatement = 'PRODID:StayOver Organizer';
	const versionStatement = 'VERSION:2.0';
	const closingStatement = 'END:VCALENDAR';
	const openEventStatement = 'BEGIN:VEVENT';
	const closeEventStatement = 'END:VEVENT';
	const methodStatement = 'METHOD:PUBLISH';
	const openStandardTimeZoneStatement = 'BEGIN:STANDARD';
	const closeStandardTimeZoneStatement = 'END:STANDARD';
	const openTimeZoneStatement = 'BEGIN:VTIMEZONE';
	const timeZoneID = 'TZID:W. Europe Standard Time';
	const closeTimeZoneStatement = 'END:VTIMEZONE';
	const eventPrivateStatement = 'CLASS:PRIVATE';
	
	// Fields
	const organizerField = 'ORGANIZER:';
	const dateBeginField = 'DTSTART:';
	const dateEndField = 'DTEND:';
	const generationTimeStampField = 'DTSTAMP:';
	const subjectField = 'SUMMARY:';
	const sequenceField = 'SEQUENCE:';
	const descriptionField = 'DESCRIPTION:';
	const uidField = 'UID:';
	//private static $
	private static $timeZone;
	
	// MS Outlook specific
	private static $busyStatus = 'X-MICROSOFT-CDO-BUSYSTATUS:BUSY';
	private static $importance = 'X-MICROSOFT-CDO-IMPORTANCE:1';
// 	private static $intendedStatus =	
	
	public function getIcalEntry(SO_DateChild $date, IF_BASE_NAMED_OBJECT $recipient){
		return new SO_Ical_Entry($date, $recipient);
	}	
}

class SO_Ical_Entry{
	
	private $date;
	private $calendarString;
	private $recipient;
	
	public function __construct(SO_DateChild $date, IF_BASE_NAMED_OBJECT $recipient){
		$this->date = $date;
		$this->recipient = $recipient;
	}
	
	public function download(){
		$this->setHeader();
		$this->setICalString();
		echo $this->calendarString;
		exit;
// 		$CI =& get_instance();
// 		$CI->load->helper('download');
// 		$name = 'termin.ics';
// 		$CI->download_helper->force_download($name, $this->calendarString);
	}
	
	public function save(){
				$CI =& get_instance();
				$CI->load->helper('file');
				$CI->file_helper->write_file('file.ics', 'test');
	}
	
	public function getiCalString(){
		if($this->calendarString == null){
			$this->setICalString();
		}
		return $this->calendarString;
	}
	
	private function setHeader(){
		header('Content-Type: application/calendar');
// 		header('Content-Disposition: attachment; filename="stay_over_appointment.txt"');
		header('Content-Disposition: attachment; filename="stay_over_appointment.ics"');
	}
	
	private function setICalString(){
		// Static opening statements
		$this->calendarString  = SO_Ical::openingStatement . "\r\n";
		$this->calendarString .= SO_Ical::prodStatement . "\r\n";
		$this->calendarString .= SO_Ical::versionStatement . "\r\n";
		$this->calendarString .= SO_Ical::methodStatement . "\r\n";
		// Date definition
		$this->calendarString .= SO_Ical::openEventStatement . "\r\n";
		
		$this->calendarString .= SO_Ical::organizerField . "michel.luther@gmail.com" . "\r\n";
		$beginDate = $this->getBeginDate();
		$this->calendarString .= SO_Ical::dateBeginField . $beginDate . "\r\n";
		$endDate = $this->getEndDate();
		$this->calendarString .= SO_Ical::dateEndField . $endDate . "\r\n";
		$generationTimeStamp = $this->getGenerationTimeStamp();
		$this->calendarString .= SO_Ical::generationTimeStampField . $generationTimeStamp . "\r\n";
		$subject = $this->getSubject();
		$this->calendarString .= SO_Ical::subjectField . $subject . "\r\n";
		$uid = $this->getUid();
		$this->calendarString .= SO_Ical::uidField . $uid . "\r\n";
		$description = $this->getDescription();
		$this->calendarString .= SO_Ical::descriptionField . $description . "\r\n";
		$this->calendarString .= SO_Ical::eventPrivateStatement . "\r\n";
		$this->calendarString .= SO_Ical::closeEventStatement . "\r\n";
		// Static closing statements
		$this->calendarString .= SO_Ical::closingStatement . "\r\n";
	}
	
	private function getGenerationTimeStamp(){
		return '20121010T200000Z';
	}
	
	private function getBeginDate(){
		$bedinDateObject = Mpm_calendar::getUTCObject($this->date->getBeginDate());	// we HAVE to work with UTC-Times
		$beginDate = Mpm_calendar::format_date_for_ical($bedinDateObject);
		$beginTime = Mpm_calendar::format_time_for_ical($bedinDateObject);
		return $beginDate . 'T' . $beginTime . 'Z';
	}
	
	private function getEndDate(){
		$endDateObject = Mpm_calendar::getUTCObject($this->date->getEndDate());	// we HAVE to work with UTC-Times
		$endDate = Mpm_calendar::format_date_for_ical($endDateObject);
		$endTime =  Mpm_calendar::format_time_for_ical($endDateObject);
		return $endDate . 'T' . $endTime . 'Z';
	}
	
	private function getSubject(){
		return $this->date->getName();
	}
	
	private function getUid(){
		return $this->recipient->getID() . '.' . $this->date->getID() . '@stayOver';
	}
	
	private function getDescription(){
		$note = $this->date->getNote(); 
		$note = str_replace("\r\n", '\n', $note);
		return $note;
	}
}