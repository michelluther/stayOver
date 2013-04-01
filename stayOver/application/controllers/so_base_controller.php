<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once './system/core/Controller.php';

define("MLU_AJAX_CONTENT", "ajaxContent");
define("MLU_AJAX_DATA", "ajaxData");
define("ROLE_PARENT", "eltern");
define("ROLE_HELPER", "helfer");
define("BASE_OBJECT_TYPE_DATE", "DATE");
define("BASE_OBJECT_TYPE_PERSON", "PERSON");
define("BASE_OBJECT_TYPE_USER", "USER");
define("BASE_OBJECT_TYPE_CHILD", "CHILD");
define("BASE_MAIL_FROM", 'do.not.reply@michelsplayground.com');
define("BASE_MAIL_FROM_TEXT", 'do not reply');

class SO_BaseController extends CI_Controller{

	protected $returnType;
	protected $header = array();
	protected $content = array();
	protected $footer = array();
	protected $banner = array();
	protected $navigation = array();
	protected $navigation_data;
	protected $msg = array();
	protected $user;
	protected $fault_view;
	protected $controller_name;
	protected $current_activity;
	
	public function __construct(){
		parent::__construct();
		set_exception_handler(array($this, '_handleError'));
		$this->banner['view'] = 'banner';
		$this->banner['data'] = null;
		$this->footer['view'] = 'footer';
		$this->footer['data'] = null;
		$this->navigation['view'] = 'navArea';
		$this->navigation['data'] = null;
		if ($this->router->fetch_method() != 'login' &&  $this->router->fetch_method() != 'submit_login'){
			$this->_get_logged_in_user();
		}
		$this->_init_navigation();
		$this->current_activity = $this->router->fetch_class() . '/' . $this->router->fetch_method();
	}

	public function index(){
		$this->_redirect_to_login();
	}

	/*
	 * Login
	 */

	public function login(){
		$this->content['view'] = 'login_screen';
		$this->content['data'] = null;
		$this->navigation['view'] = null;
		$this->banner['view'] = null;
		$this->_callView();
	}

	public function submit_login(){
		try{
			$this->fault_view = 'login_screen';
			$this->navigation['view'] = null;
			$credentials = $this->_extract_credentials();
			$uname = $credentials['uname'];
			$pw = $credentials['pw'];
			SO_User::login($uname, $pw);
			$this->user = SO_User::getInstance();
		//	$this->_init_navigation();								// needs to be redone, because it would fail in constructor
			$this->_init_session_cookie($this->user);
			$this->_returnFeedback(BASE_MSG_SUCCESS, 'Du bist eingeloggt');
			//$this->_setFeedback(BASE_MSG_SUCCESS, 'Du bist eingeloggt');
		} catch(Exception $e){
			$this->_returnFeedback(BASE_MSG_ERROR, $e->getMessage());
		}
	}
	
	public function logout(){
		$this->_clear_session();
		$this->login();
	}

	protected function _extract_credentials(){
		$credentials = array('uname' => $_POST['login']['uname'],
							 'pw'	 => $_POST['login']['pw'] );
		return $credentials;
	}

	/*
	 * Sessionmanagement
	 */

	protected function _init_session_cookie(SO_User $user){
		$this->session->set_userdata('uname', $user->getID());
		$this->session->set_userdata('logged_in', true);
	}

	protected function _get_logged_in_user(){
		if(isset($this->session->userdata['logged_in']) && ($this->session->userdata['logged_in'] == true)){
			$this->user = SO_User::getLoggedInUser($this->session->userdata['uname'], null);
		} else {
			$this->_redirect_to_login();
		}
	}
	
	protected function _clear_session(){
		$this->session->sess_destroy();
	}

	/*
	 * Navigation
	 */

	protected function _redirect_to_login(){
		// TODO: Set Cookie Information for Redirect after successful login
		$this->session->set_userdata('redirected_from', 'admin/start');
		$loginURL = base_url() . 'index.php/' . $this->router->fetch_class() . '/login';
		redirect($loginURL);
	}

	protected function _init_navigation(){
		if ($this->user != null){
			$this->navigation_data = $this->Navigation_model->init_navigation($this->user);
			$this->navigation['view'] = 'navArea';
		}
	}

	/*
	 * Output to browser
	 */

	protected function _callView(){
		switch ($this->returnType) {
			case MLU_AJAX_CONTENT:
				$view_array = array('content' => $this->content );
				$this->load->view('ajax_content', $view_array);
				break;
			case MLU_AJAX_DATA:		
				$view_data = array();
				$this->load->view('ajax_data', $this->content['data']);
				break;
			default:
				if($this->navigation_data != null){
					$this->mpm_navigation->set_active_entry($this->navigation_data, $this->current_activity);
				}
				$this->navigation['data'] = $this->navigation_data;
				$view_array = array( 'banner' => $this->banner,
									 'header' => $this->header,
									 'navigation' => $this->navigation,
									 'msg' => $this->msg,
									 'content' => $this->content,
									 'footer' => $this->footer 
								);
				$this->load->view('site', $view_array);
		}
	}
	
	/*
	 * Error and Success Handling
	 */
	protected function _handleError(Exception $e){
		$this->msg = array(	'msg_class' => 'msg_error',
						   	'msg_text'	=> $e->getMessage());
		$this->content['view'] = $e->get_fault_view();
		if($this->content['view'] == null){
			$this->content['view'] = 'login_screen';
		}
		$this->content['data'] = $e->get_fault_data();
		$this->_callView();
		//		$this->load->view('system_feedback');
	}
	
	protected function _setFeedback($msgClass, $msgText){
		$this->msg = $this->base_messager->get_message($msgClass, $msgText);
	}
	
	protected function _returnFeedback($msgClass, $msgText){
		$msg = $this->base_messager->get_message($msgClass, $msgText);
		$this->load->view('ajax_data', array('ajax_data' => array($msg)));
	//	if()
		//$this->load->view('ajax_data', $return);
	}
}
