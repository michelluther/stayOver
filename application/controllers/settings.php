<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once 'so_base_controller.php';

class Settings extends SO_BaseController{

	public function __construct(){
		parent::__construct();
	}

	public function index(){
		array_push($this->header['data']['js'], 'settings');
		$this->content['data']['user'] = $this->user;
		$parent = $this->user->getParent();
		if ($parent != null){
			$kinder = $parent->getChildren();
			$this->content['data']['display']['parentKids'] = true;
			$this->content['data']['kids'] = $kinder;
		}
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

	public function changePassWord(){
		try {
			$clientArray = $_POST["form"]["password"];
			if($clientArray["newPassword"] != $clientArray["newPasswordConfirm"]){
				throw new Mpm_Exception('Bitte gib zwei Mal das selbe neue Passwort ein.');
			}
			$user = $this->user;
			$user->changePassword($clientArray["password"], $clientArray["newPassword"]);
			$this->_returnFeedback(BASE_MSG_SUCCESS, "Passwort erfolgreich geändert.");
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
	
	public function inviteHelper($childID){
		try{
			$this->returnType = MLU_AJAX_DATA;
			$parent = $this->user->getParent();
			$childPerson = SO_PeopleFactory::getPerson($childID);
			$child = new SO_Child($childPerson);
			$emailAddress = $_POST["form"]["inviteeEmail"];
			$this->load->model('Registration_model');
			$invitation = $parent->inviteHelper($emailAddress, $child);
			$this->_sendInvitationMail($emailAddress, $invitation->getRegistrationKey(), $child);
			$this->_returnFeedback(BASE_MSG_SUCCESS, "Der Helfer wurde eingeladen");
		} catch (Mpm_Exception $e){
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}

	private function _sendInvitationMail($recipient, $registrationKey, $kid){
		$currentUser = SO_User::getInstance();
		$this->email->clear();
		$this->email->from(BASE_MAIL_FROM, BASE_MAIL_FROM_TEXT);
		$this->email->subject('�nderungen an Termin für ' . $kid->getName() );
		$emailMessage = $this->_setEmailHTMLHeader();
		$emailMessage .= $this->_setEmailHTMLBody('<p>Hallo lieber Helfer,</p>'
				. '<p>' . $currentUser->getName( ) . ' hat Dich eingeladen, als Helfer von ' . $kid->getName() . ' bei dem Programm "LittlesHelper" mitzumachen.</p>'
				. '<p>Du kannst Dich unter mit folgendem Registrierungsschl�ssel bei LittlesHelper.de anmelden.</p>' 
				. '<p><b>' . $registrationKey . '</b></p>'
				. '<p>Wir freuen uns auf Dich.</p>');
		$emailMessage .= $this->_setEmailHTMLFooter();
		$this->email->message($emailMessage);
		$this->email->to($recipient);
	//	$this->email->send();
	}
}