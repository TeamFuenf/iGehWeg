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
    $data["friends"] = $this->Friends_model->get_friends($userid);
    $data["newmessages"] = $this->Messaging_model->countUnreadMessages();

   // $data["knearestfriends"] = $this->Friends_model->getKNearestFriends(5);
    
    $data["eventlink"] = anchor("#", "<img src='../../images/newevent_blue.png' /><div id='button_header'>Events<br><span class='additional_text'>Hier kannst du neue Events erstellen</span></div>", array( 'class' => 'list_entry'));
    $data["friendlink"] = anchor("/friends/friends_control/add_friends_main", "<img src='../../images/groupmember_green.png' /><div id='button_header'>Freunde<br><span class='additional_text'>Hier kannst du neue Freunde finden</span></div>", array( 'class' => 'list_entry'));

	$data["logoutlink"] = anchor("/base/login_control/logout", "<div id='logout_button'><img src='../../images/logout.png' /><p>Logout</p></div>");      

    $this->layout->view("dashboard/dashboard", $data);
  }

}
