<?php

class Timeline extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();
 
    $this->load->model("timeline/Timeline_event");
  }
       
  public function index()
  {
     
  }

}

?>