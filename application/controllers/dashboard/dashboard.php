<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
  
  public function index()
  {    
    $this->layout->view("dashboard/dashboard");
  }

}