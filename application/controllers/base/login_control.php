<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_control extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
  }

  public function index()
  {
    $is_logged_in = $this->session->userdata("is_logged_in");
    if($is_logged_in == true)
    {
      if ($this->session->userdata("lastpage"))
      {
        redirect($this->session->userdata("lastpage"));                
      }
      else
      {
        redirect("/dashboard/dashboard");        
      }
  	}
  	else
  	{
      $this->layout->view("/base/login");
  	}
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
		redirect("/dashboard/dashboard");
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
		
		//Damit auch wirklich alles weg ist beim ausloggen :)
		$this->session->set_userdata('is_logged_in', false);
		$this->session->unset_userdata('is_logged_in');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('userid');
        //Destroy session
        $this->CI->session->sess_destroy();
		
		$this->index();
  }
}
