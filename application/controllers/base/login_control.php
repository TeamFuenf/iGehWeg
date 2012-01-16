<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_control extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
    parse_str($_SERVER["QUERY_STRING"], $_GET); 
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
  
  public function twitterlogin()
  {
    $params["key"] =  "NKjLJqkn5O09P7KfctZrw";
    $params["secret"] = "jpFktjfRAEiuYXgWA0s5MuNQUsCnJgkgrdyxZmdcds";
    $this->load->library("twitter_oauth", $params); 

    if ($this->uri->segment(3) == "success")
    {
      $response = $this->twitter_oauth->get_access_token(false, $this->session->userdata("token_secret"));  
      echo "Hallo ".$response["screen_name"];
      // TODO: 
      // - User ggf. erzeugen oder logindaten holen
      // - Erfolgreichen Login und Username in Session speichern
      // - Im Login Controller bei gesetzten Sessiondaten auf Dashboard weiterleiten, da bei Fokus der App Loginseite aufgerufen wird
    }
    else
    {
      $response = $this->twitter_oauth->get_request_token(site_url("login/twitter/success"));  
      $this->session->set_userdata("token_secret", $response["token_secret"]);
      redirect($response["redirect"]);        
    }
  }

  public function googlelogin()
  {
    $this->load->library("openid");
    try {
      if(!isset($_GET["openid_mode"]))
      {
        $openid = new Openid("http://localhost");
        $openid->identity = "https://www.google.com/accounts/o8/id";
        $openid->required = array(
          "namePerson",
          "namePerson/first",
          "namePerson/last",
          "contact/email",
        );      
        header("Location: ".$openid->authUrl());
      }
      elseif ($_GET["openid_mode"] == "cancel")
      {
        echo "User has canceled authentication!";        
      }
      else
      {
        $openid = new Openid;
        if($openid->validate())
        {
          $data = $openid->getAttributes();
          $email = $data["contact/email"];
          $first = $data["namePerson/first"];
          $last = $data["namePerson/last"];
          echo "Hallo ".$first." ".$last;
          // TODO: 
          // - User ggf. erzeugen oder logindaten holen
          // - Erfolgreichen Login und Username in Session speichern
          // - Im Login Controller bei gesetzten Sessiondaten auf Dashboard weiterleiten, da bei Fokus der App Loginseite aufgerufen wird
        }
        else
        {
          echo "User has not logged in.";
        }
      }
    }
    catch(ErrorException $e)
    {
      echo $e->getMessage();
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
