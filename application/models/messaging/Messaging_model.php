<?php

class Messaging_model extends CI_Model
{
    
  function __construct()
  {
    parent::__construct();
    $this->load->model("friends/Friends_model");
  }
  
// --------------------------------------------------------------------------------------------------------------------

  public function send($to, $body)
  {
    $message["id"] = "";
    $message["to"] = $to;
    $message["from"] = $this->session->userdata("userid");
    $message["time"] = time();
    $message["body"] = $body;
    $message["status"] = "unread";
    $this->db->insert("message", $message);
  }

  public function getMessages()
  {
    $receiver = $this->session->userdata("userid");
    $this->db->where("to", $receiver);
    $this->db->order_by("time", "asc");
    $query = $this->db->get("message");
    return $query->result();    
  }

  public function getUnreadMessages()
  {
    $receiver = $this->session->userdata("userid");
    $this->db->where("to", $receiver);
    $this->db->where("status", "unread");
    $this->db->order_by("time", "asc");
    $query = $this->db->get("message");
    return $query->result();    
  }

  public function getReadMessages()
  {
    $receiver = $this->session->userdata("userid");
    $this->db->where("to", $receiver);
    $this->db->where("status", "read");
    $this->db->order_by("time", "asc");
    $query = $this->db->get("message");
    return $query->result();        
  }
  
  public function getMessage($messageid)
  {
    $this->db->where("id", $messageid);
    $query = $this->db->get("message");
    return $query->row();        
  }
  
  public function markAsRead($messageid)
  {
    $message = $this->getMessage($messageid);
    $message->status = "read";    
    $this->db->where("id", $messageid);
    $this->db->update("message", $message);          
  }
  
  public function delete($messageid)
  {
    $this->db->where("id", $messageid);
    $this->db->delete("message");
  }
  
// --------------------------------------------------------------------------------------------------------------------

  public function getNewMessageForm()
  {
    $userid = $this->session->userdata("userid");
    $friends = $this->Friends_model->get_friends($userid);
    foreach($friends as $friend)
    {
      $receivers[$friend->id] = $friend->name;
    }
    
    $buffer  = "";
    $buffer .= form_open("newmessage");
    $buffer .= "<div id='mailstatus'></div>";
    $buffer .= form_dropdown("receiver", $receivers);
    $buffer .= br();
    $buffer .= form_textarea("messagetext");
    $buffer .= br();
    $buffer .= form_button("sendmail","senden");
    $buffer .= form_close();
    return $buffer;  
  }


}
