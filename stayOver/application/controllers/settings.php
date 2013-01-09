<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'so_base_controller.php';

class Settings extends SO_BaseController{

	public function __construct(){
		parent::__construct();
	}

	public function start(){
		$this->header['data']['js'] = array('settings');
		$this->content['data']['user'] = $this->user;
		$parent = $this->user->getParent();
		if ($parent != null){
			$kids = $parent->getChildren();
		}
		$this->content['data']['kids'] = $kids;
		$this->content['view'] = 'settings';
		$this->_callView();
	}

	public function saveUserData(){
		try {
			$clientArray = $_POST["form"]["user"];
			$user = SO_User::getInstance();
			$user->setEmail($clientArray['email']);
			$user->setFirstName($clientArray['firstname']);
			$user->setLastName($clientArray['lastname']);
			$changesMade = $user->save();
			if($changesMade == true){
				$this->_returnFeedback(BASE_MSG_SUCCESS, "Benutzerdaten erfolgreich gespeichert");
			} else {
				$this->_returnFeedback(BASE_MSG_SUCCESS, "Es wurden keine &Auml;nderungen vorgenommen");
			}
		} catch (Mpm_Exception $e){
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}

	}

	public function removeHelper($childID, $helperID){
		$parent = $this->user->getParent();
		try{
			if ($parent != null){
				$helper = SO_PeopleFactory::getPerson($helperID);
				$child = SO_PeopleFactory::getPerson($childID);
				$parent->unassignHelperFromChild($child, $helper);
				$this->_returnFeedback(BASE_MSG_SUCCESS, "Helfer erfolgreich entfernt");
			}
		} catch(Mpm_Exception $e){
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function assignHelper($childID, $helperID){
		$parent = $this->user->getParent();
		try{
			if ($parent != null){
				$helper = SO_PeopleFactory::getPerson($helperID);
				$child = SO_PeopleFactory::getPerson($childID);
				$parent->assignHelperToChild($child, $helper);
				$this->_returnFeedback(BASE_MSG_SUCCESS, "Helfer erfolgreich hinzugef&uuml;gt");
			}
		} catch(Mpm_Exception $e){
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function getAssignedHelpers($childID){
		$this->returnType = MLU_AJAX_CONTENT;
		$parent = $this->user->getParent();
		$child = $parent->getChild($childID);
		$this->content['data']['availableHelpers'] = $child->getHelpers();
		$this->content['data']['kid'] = $child;
		$this->content['view'] ='popins/assigned_helpers';
		$this->_callView();
	}

	public function saveChildData($childID){
		try{
			$clientArray = $_POST["form"]["kid"];
			$child = SO_PeopleFactory::getPerson($childID);
			$child->setFirstName($clientArray['firstName']);
			$child->setLastName($clientArray['lastName']);
			$changesMade = $child->save();
			if($changesMade){
				$this->_returnFeedback(BASE_MSG_SUCCESS, "Daten zum Kind gespeichert.");
			} else {
				$this->_returnFeedback(BASE_MSG_SUCCESS, "Es wurden keine Änderungen vorgenommen.");
			}
		} catch(Mpm_Exception $e) {
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function getRemoveChildConfirm($childID){
		$this->returnType = MLU_AJAX_CONTENT;
		$child = SO_PeopleFactory::getPerson($childID);
		$this->content['data']['child'] = $child;
		$this->content['view'] ='popins/delete_child_confirm';
		$this->_callView();
	}

	public function removeChild($childID){
		try{
			$parent = $this->user->getParent();
			$child = $parent->getChild($childID);
			$changesMade = $parent->removeChild($child);
			if($changesMade){
				$this->_returnFeedback(BASE_MSG_SUCCESS, "Kind wurde entfernt");
			} else {
				$this->_returnFeedback(BASE_MSG_SUCCESS, "Es wurden keine Änderungen vorgenommen.");
			}
		} catch(Mpm_Exception $e) {
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}
	
	public function addChild(){
		$firstName = $_POST["form"]["kid"]['firstName'];
		$lastName = $_POST["form"]["kid"]['lastName'];
		$parent = $this->user->getParent();
		$child = SO_PeopleFactory::createPerson($firstName, $lastName);
		$child->save();
		$parent->addChild($child);
		$this->_returnFeedback(BASE_MSG_SUCCESS, "Kind wurde angelegt");
	}

	public function addChildPopup(){
		$this->returnType = MLU_AJAX_CONTENT;
		$this->content['data'] = null;
		$this->content['view'] ='popins/add_child_form';
		$this->_callView();
	}
	
	public function getAssignedChildren(){
		$this->returnType = MLU_AJAX_CONTENT;
		$parent = $this->user->getParent();
		if ($parent != null){
			$kids = $parent->getChildren();
		}
		$this->content['data']['kids'] = $kids;
		$this->content['view'] = 'include/assigned_children';
		$this->_callView();
	}
	
	public function manageHelpersPopup($childID){
		try{
			$this->returnType = MLU_AJAX_CONTENT;
			$parent = $this->user->getParent();
			$child = $parent->getChild($childID);
			$this->content['data']['kid'] = $child;
			if(!isset($child)){
				throw new Mpm_Exception('Dieses Kind existiert nicht');
			}
			$this->content['data']['availableHelpers'] = $child->getHelpers();
			$this->content['view'] = 'popins/change_child_helpers_form.php';
			$this->_callView();
		} catch(Mpm_Exception $e){
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	public function searchHelpers($searchString){
		$this->returnType = MLU_AJAX_DATA;
		$this->content['data']['ajax_data'] = SO_PeopleFactory::searchPeopleGeneric($searchString);
		$this->_callView();
	}
}