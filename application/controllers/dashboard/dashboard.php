<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();  
    $this->load->model("base/Login_model");    
    $this->load->model("friends/Friends_model");    
    $this->load->model("Messaging/Messaging_model");    
  }
  
  public function index()
  {
      
    $userid = $this->session->userdata("userid");
    // HACK: Provisorische Lösung
    if ($userid == false)
    {
      $this->session->set_userdata("userid", "123");
      $userid = 123;
    }
    
    $data["user"] = $this->Friends_model->get_user($userid);
    
    $data["inbox"] = $this->Messaging_model->getUnreadMessages();
    
    $data["eventlink"] = anchor("#", "Veranstaltung erstellen");
    $data["friendlink"] = anchor("#", "Freunde und Gruppen verwalten");
    $data["locationlink"] = anchor("#", "Location bearbeiten");
    
    // Seite 2
    $data["loginform"] = $this->Login_model->getUsers();      

    // Seite 3
    $data["messageform"] = $this->Messaging_model->getNewMessageForm();

    $this->layout->view("dashboard/dashboard", $data);
  }

}
