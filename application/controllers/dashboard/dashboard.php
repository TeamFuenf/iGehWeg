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
    
    $data["eventlink"] = anchor("#", "Veranstaltung erstellen");
    $data["friendlink"] = anchor("#", "Freunde und Gruppen verwalten");
    $data["locationlink"] = anchor("#", "Location bearbeiten");
    
    $data["logoutlink"] = anchor("/base/login_control/logout", "Logout");      

    $this->layout->view("dashboard/dashboard", $data);
  }

}
