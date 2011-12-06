<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();  
    $this->load->model("base/Login_model");    
    $this->load->model("friends/Friends_model");    
  }
  
  public function index()
  {
    $userid = $this->session->userdata("userid");
    $data["loginform"] = $this->Login_model->getUsers();      
    $data["user"] = $this->Friends_model->get_user($userid);
    
    $data["eventlink"] = anchor("#", "Veranstaltung erstellen");
    $data["friendlink"] = anchor("#", "Freunde und Gruppen verwalten");
    $data["locationlink"] = anchor("#", "Location bearbeiten");
    
    $this->layout->view("dashboard/dashboard", $data);
  }

}
