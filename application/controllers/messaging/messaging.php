<?php

class Messaging extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();  
    $this->load->model("messaging/Messaging_model");   
    $this->load->model("friends/Friends_model");        
  }

  private $dateformat = "H:i:s d.m.Y";
  
// --------------------------------------------------------------------------------------------------------------------

  public function show()
  {    
    $messageid = $this->uri->segment(3);
    $msg = $this->Messaging_model->getMessage($messageid);
    $msg->from = $this->Friends_model->get_user($msg->from);
    $msg->time = date($this->dateformat, $msg->time);
    print_r($msg);
  }

  public function send()
  {
    $to = $this->input->post("to", true);
    $body = $this->input->post("message", true);
    $this->Messaging_model->send($to, $body);
    echo "okay";  
  }

}
?>