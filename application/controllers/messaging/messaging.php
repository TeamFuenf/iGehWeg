<?php

class Messaging extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();
	parent::is_logged_in();  
    $this->load->model("messaging/Messaging_model");   
    $this->load->model("friends/Friends_model");        
  }

  private $dateformat = "H:i:s d.m.Y";
  
// --------------------------------------------------------------------------------------------------------------------

/*
  public function showMessage()
  {
    $messageid = $this->uri->segment(3);
    $msg = $this->Messaging_model->getMessage($messageid);
    $msg->from = $this->Friends_model->get_user($msg->from);
    $msg->time = date($this->dateformat, $msg->time);
    print_r($msg);    
  }
*/

  public function hide()
  {
    $messageid = $this->uri->segment(3);
    $this->Messaging_model->hideMessage($messageid);
    echo "okay";
  }

  public function inbox()
  {
    $userid = $this->session->userdata("userid");    
    $data["messages"] = $this->Messaging_model->getInbox();
    $data["receivers"] = $this->Friends_model->get_friends($userid);
    $this->layout->view("messaging/inbox", $data);        
  }
  
  public function show()
  {
    $userid = $this->session->userdata("userid");    
    $receiver = $this->uri->segment(2);    
    $messages = $this->Messaging_model->getMessageStream($receiver);
    $data["messages"] = $messages;
    $data["userid"] = $userid;
    $data["receiver"] = $this->Friends_model->get_user($receiver);
    $data["me"] = $this->Friends_model->get_user($userid);
    $data["messageform"] = $this->Messaging_model->getNewMessageForm($receiver);
    $this->layout->view("messaging/messagestream", $data);
  }

  public function send()
  {
    $to = $this->input->post("receiver", true);
    $body = $this->input->post("message", true);
    $this->Messaging_model->send($to, $body);
    echo "okay";  
  }

}
?>