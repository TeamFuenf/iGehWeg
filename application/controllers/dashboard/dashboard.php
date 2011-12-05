<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();  
    $this->load->model("base/Login_model");    
  }
  
  public function index()
  {
    $data["loginform"] = $this->Login_model->getUsers();    
    $this->layout->view("dashboard/dashboard", $data);
  }

}
