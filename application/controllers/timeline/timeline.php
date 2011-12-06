<?php

class Timeline extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();  
    $this->load->model("timeline/Timeline_model");    
  }

  public function index()
  {
    $userid = $this->session->userdata("userid");
    $data["events"] = $this->Timeline_model->getEvents($userid);
    $data["createlink"] = $this->Timeline_model->createlink();
    $this->layout->view("timeline/timeline", $data);
  }

}
?>