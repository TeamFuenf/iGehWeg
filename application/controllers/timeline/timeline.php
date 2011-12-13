<?php

class Timeline extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();  
    $this->load->model("event/Event_model");    
  }

  public function index()
  {
    $userid = $this->session->userdata("userid");
    $data["createlink"] = anchor("event/new", "+");
    $data["userid"] = $userid;
    $data["ownevents"] = $this->Event_model->getOwnEvents();
    $data["participatingeventsts"] = $this->Event_model->getParticipatingEvents();

    $this->layout->view("timeline/timeline", $data);
  }

}
?>