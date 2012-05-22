<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

include_once './system/core/Controller.php';


define("MLU_AJAX_CONTENT", "ajaxContent");
define("MLU_AJAX_DATA", "ajaxData");

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
		$this->navigation['view'] = 'navigation';
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
			$this->user = $this->User_model->login($credentials);
			$this->_init_navigation();								// needs to be redone, because it would fail in constructor
			$this->_init_session_cookie($this->user);
			$this->_handleSuccess('Du bist eingeloggt');
		} catch(Exception $e){
			$this->_handleError($e);
		}
	}

	protected function _extract_credentials(){
		$credentials = array('uname' => $_POST['uname'],
							 'pw'	 => $_POST['pw'] );
		return $credentials;
	}

	/*
	 * Sessionmanagement
	 */

	protected function _init_session_cookie($user){
		$this->session->set_userdata('uname', $user->uname);
		$this->session->set_userdata('logged_in', true);
	}

	protected function _get_logged_in_user(){
		if($this->session->userdata['logged_in'] ==  true){
			$this->user = $this->User_model->get_user_for_uname($this->session->userdata['uname']);
		} else {
			$this->_redirect_to_login();
		}
	}

	/*
	 * Navigation
	 */

	protected function _redirect_to_login(){
		$loginURL = base_url() . 'index.php/' . $this->router->fetch_class() . '/login';
		redirect($loginURL);
	}

	protected function _init_navigation(){
		if ($this->user != null){
			$this->navigation_data = $this->Navigation_model->init_navigation($this->user);
			$this->navigation['view'] = 'navigation';
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

	protected function _handleSuccess($msg){
		$msgArray = array('msg_class' 	=> 'msg_success',
										 	 'msg_text'		=> $msg);
		$this->msg = $msgArray;
	//	if()
		//$this->load->view('ajax_data', $return);
	}
}
