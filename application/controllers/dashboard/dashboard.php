<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();
    parent::is_logged_in(); 
    $this->load->model("base/Login_model");
    $this->load->model("friends/Friends_model");
    $this->load->model("messaging/Messaging_model");
  }
  
  public function index()
  {
      
    $userid = $this->session->userdata("userid");
    
    $data["user"] = $this->Friends_model->get_user($userid);
    
    $data["newmessages"] = $this->Messaging_model->countUnreadMessages();
    $data["knearestfriends"] = $this->Friends_model->getKNearestFriends(5);
    
    $data["eventlink"] = anchor("#", "<img src='../../images/event_new.png' /><div id='button_header'>Events<br><span class='additional_text'>Hier kannst du neue Events erstellen</span></div>", 'class="button_long blue"');
    $data["locationlink"] = anchor("#", "<img src='../../images/location_edit.png' /><div id='button_header'>Locations<br><span class='additional_text'>Hier kannst du neue Locations hinzufügen</span></div>", 'class="button_long green"');
    
    // Seite 2
    // $data["loginform"] = $this->Login_model->getUsers();
	$data["logoutlink"] = anchor("/base/login_control/logout", "<div id='logout_button'><img src='../../images/logout.png' /><p>Logout</p></div>");      

    $this->layout->view("dashboard/dashboard", $data);
  }

}
