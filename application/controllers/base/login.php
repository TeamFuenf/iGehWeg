<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

/**
 * NUR TESTWEISE 
 * 
 * um Userids in die Session zu legen bzw. zwischen Users zu wechseln
 */

  public function __construct()
  {
    parent::__construct();  
  }

  public function index()
  {
    $userid = $this->input->post("userid");
    $this->session->set_userdata("userid", $userid);
    //redirect("/");
    
    $this->layout->view("base/login");
  }
  
}
