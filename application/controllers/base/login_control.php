<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_control extends CI_Controller {

/**
 * NUR TESTWEISE 
 * 
 * um Userids in die Session zu legen bzw. zwischen Users zu wechseln
 */

  public function __construct()
  {
    parent::__construct();  
  }

  public function index()
  {/*
    $userid = $this->input->post("userid");
    $this->session->set_userdata("userid", $userid);
    //redirect("/");
    
    $this->layout->view("base/login");*/
	
	
	//$this->load->model("/base/simplelogin");
	
	$this->layout->view("/base/login");
	
  }
  
  public function validate_credentials() {
  	
	$this->load->model("/base/login_model");
	$query = $this->login_model->validate();
	
	if(isset($query)) {    //wenn es den Usernamen wirklich gibt
	
		foreach($query->result() as $item) 
			{
				$zeugs[] = $item;
			}
	
		$data = array(
				'username' => $this->input->post('username'),
				'userid' => $zeugs[0]->id,
				'is_logged_in' => true
		);
		
		$this->session->set_userdata($data);
		redirect("/");
	} else {
		$this->index();
	}
  }
  
  public function signup() {
  	
	$this->layout->view("/base/signup_view");
	
  }
  
  public function create_user() {
  		
	//Prüft ob die Eingaben passen
  	$this->load->library('form_validation');
	
	// set_rules(welches Inputfeld, Fehlermeldung, Regel)
	$this->form_validation->set_rules('username', 'Username', 'trim|required');
	$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
	
	if($this->form_validation->run() == FALSE) {
		//Validierung fehlgeschlagen
		$this->layout->view('/base/signup_view');
	} else {
		//Wenn alles passt wird der neue User angelegt
		$this->load->model('/base/login_model');
		if($query = $this->login_model->create_user()) {
			$this->layout->view('/base/signup_success');
		} else {
			$this->layout->view('/base/signup_view');
		}
	}
	
  }
  
  public function logout() {
        $this->CI =& get_instance();        

        //Destroy session
        $this->CI->session->sess_destroy();
		
		$this->index();
  }
  
  /*public function login_user($username, $password) {
  	$this->load->model("/base/simplelogin");
	
	$result = $this->simplelogin->login($username, $password);
	
	if($result != true) {
		//$this->simplelogin->create($username, $password);
		$this->CI =& get_instance();
		$test = $this->CI->session->userdata('username');
		echo $test;
	} else {
		
		echo "<div>Hi, du bist jetzt eingelogged!</div>";
	}
  }
  
  public function logout_user() {
  	$this->load->model("/base/simplelogin");
	
	$this->simplelogin->logout();
	//$this->CI =& get_instance();
	//$this->CI->session->unset_userdata('username');
	
  }
  
  public function session_test() {
  	$this->CI =& get_instance();
		
	$test = $this->CI->session->userdata('username');
	echo $test;
  }*/
  
  
  
}
