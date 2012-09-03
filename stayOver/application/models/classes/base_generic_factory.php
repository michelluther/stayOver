<?php
class SO_GenericFactory{
	
	public static function getObject($objectType, $objectID){
		switch ($objectType) {
			case BASE_OBJECT_TYPE_PERSON:
			 	$returnObject = SO_PeopleFactory::getPerson($objectID);
			break;
			case BASE_OBJECT_TYPE_DATE:
				$returnObject = SO_DateFactory::getDate($objectID);
			case BASE_OBJECT_TYPE_USER:
				$returnObject = null;
			default:
				throw new Mpm_Exception('Unsupported Object Type');
			break;
		}
		return $returnObject;
	}
}