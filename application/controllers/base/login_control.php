<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Default Controller. Wird beim Start der Anwendung aufgerufen. Ist für den normalen Login, 
 * TwitterLogin, GoogleLogin, Logout und das Anlegen von neuen Benutzern verantwortlich.
 */
class Login_control extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
    $this->load->model("/base/login_model");
    parse_str($_SERVER["QUERY_STRING"], $_GET); 
  }

  /**
   * Überprüft ob ein Benutzer schon eingeloggt ist (durch Cookie) und falls dies zutrifft wird er 
   * sofot zum Dashboard weitergeleitet. Falls nicht gelangt er zu Loginseite.
   */
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
  
  /**
   * Realisiert den Login über Twitter.
   */
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

  /**
   * Realisiert den Login über Google.
   */
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
          $userid = $first.$last; 
          $username = $first." ".$last;

          // Nur für Demozwecke (!!) : Username als Kennwort setzen
          $result = $this->login_model->create_user($userid, $username, $username);

          $data["username"] = $username;
          $data["userid"] = $userid;
          $data["is_logged_in"] = true;

          $this->session->set_userdata($data);
          redirect("/dashboard/dashboard");            
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
  
  /**
   * Validiert den Benutzernamen und leitet bei korrektem Namen zum Dashboard weiter. Falls nicht wird
   * wieder die index()-Funktion aufgerufen.
   */
  public function validate_credentials()
  {
    $query = $this->login_model->validate();
	
    if(isset($query)) //wenn es den Usernamen wirklich gibt
    {
      foreach($query->result() as $item) 
			{
        $zeugs[] = $item;
			}

      $data["username"] = $this->input->post("username");
      $data["userid"] = $zeugs[0]->id;
      $data["is_logged_in"] = true;
		
      $this->session->set_userdata($data);
      redirect("/dashboard/dashboard");
    }
    else
    {
      $this->index();
  	}
  }
  
  /**
   * Leitet den Benutzer zur Registrierungsseite weiter.
   */
  public function signup()
  {
    $this->layout->view("/base/signup_view");
  }
  
  /**
   * Erstellt neuen Benutzer bei validen Eingaben.
   */
  public function create_user()
  {
    //Prüft ob die Eingaben passen
    $this->load->library('form_validation');
	
    // set_rules(welches Inputfeld, Fehlermeldung, Regel)
    $this->form_validation->set_rules('username', 'Username', 'trim|required');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
	
    if($this->form_validation->run() == FALSE)
    {
		  //Validierung fehlgeschlagen
      $this->layout->view('/base/signup_view');
    }
    else
    {
      //Wenn alles passt wird der neue User angelegt
      $this->load->model('/base/login_model');
      $username = $this->input->post("username", true);
      $password = $this->input->post("password", true);
      
      if($query = $this->login_model->create_user(uniqid("user"), $username, $password))
      {
        redirect(site_url(""));
      }
      else
      {
        $this->layout->view('/base/signup_view');
      }
    }
  }
  
  /**
   * Loggt einen Benutzer wieder aus.
   */
  public function logout()
  {
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

// ------------------------------------------------------------------------------------------------
}
