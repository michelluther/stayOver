<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ML_Controller extends CI_Controller{

	protected $content = array();
	protected $footer = array();
	protected $header = array();
	protected $navigation = array();
	protected $msg = array();
	
	public function __construct(){
		set_exception_handler(array($this, '_handleError'));
		$this->header['view'] = 'header';
		$this->header['data'] = null;
		$this->footer['view'] = 'footer';
		$this->footer['data'] = null;
		$this->navigation['view'] = 'navigation';
		$this->navigation['data'] = null;
		parent::__construct();
	}

	public function index(){
		$this->content['view'] = 'login_screen';
		$this->content['data'] = null;
		$this->_callView();	
	}

	public function submit_login(){
		$credentials = $this->_extract_credentials();
		$user = $this->User_model->login($credentials);
		$this->_init_session($user);
		$msg = $this->_handleSuccess('Du bist eingeloggt');
		$this->content['view'] = 'home';
		$this->content['data'] = null;
		$this->_callView();
	}

	public function _extract_credentials(){
		$credentials = array('uname' => $_POST['uname'],
							 'pw'	 => $_POST['pw'] );
		return $credentials;
	}
	
	protected function _init_session($user){
		$this->session->set_userdata('uname', $user->uname);
	}

	protected function _callView(){
		$view_array = array( 'header' => $this->header,
							 'navigation' => $this->navigation,
							 'msg' => $this->msg,
							 'content' => $this->content,
							 'footer' => $this->footer );
		$this->load->view('site', $view_array);
	}
	
	public function _handleError(Exception $e){
		$return = array('msg_class' => 'msg_error',
						'msg_text'	=> $e->getMessage());
		$this->load->view('system_feedback', $return);
	}

	private function _handleSuccess($msg){
		$return = array('msg_class' => 'msg_success',
						'msg_text'	=> $msg);
		return $return;
	}
}
