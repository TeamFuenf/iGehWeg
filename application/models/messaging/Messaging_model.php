<?php

class Messaging_model extends CI_Model
{
    
  function __construct()
  {
    parent::__construct();
    $this->load->model("friends/Friends_model");
    $this->load->helper("form");
  }
  
// --------------------------------------------------------------------------------------------------------------------

  public function send($receiver, $body)
  {
    $message["messageid"] = "";
    $message["receiver"] = $receiver;
    $message["sender"] = $this->session->userdata("userid");
    $message["time"] = time();
    $message["body"] = $body;
    $message["status"] = "unread";
    if ($message["sender"] != $message["receiver"])
    {
      $this->db->insert("message", $message);      
    }
  }

  public function countUnreadMessages()
  {
    $receiver = $this->session->userdata("userid");
    $this->db->where("receiver", $receiver);
    $this->db->where("status", "unread");
    $query = $this->db->get("message");
    return $query->num_rows();
  }

  /**
   * Ruft den Posteingang eines Benutzers ab.
   * Mehrere Nachrichten von einem Absender werden dabei gruppiert und nur die aktuellste Nachricht wird angezeigt
   */
  public function getInbox()
  {
    $receiver = $this->session->userdata("userid");
    $sql = "
SELECT message.messageid, message.time, message.body, message.status, user.name, user.picture, user.id as userid
FROM message 
INNER JOIN 
(
SELECT MAX(messageid) AS id 
FROM message 
WHERE receiver = '".$receiver."'
AND showreceiver = 1
GROUP BY sender
) ids 
ON message.messageid = ids.id 
JOIN user
ON user.id = message.sender
ORDER BY time DESC
";
    $query = $this->db->query($sql);
    return $query->result();
  }

  public function getMessage($messageid)
  {
    $this->db->where("messageid", $messageid);
    $query = $this->db->get("message");
    return $query->row();        
  }

  public function markAsRead($messageid)
  {
    $message = $this->getMessage($messageid);
    $message->status = "read";    
    $this->db->where("messageid", $messageid);
    $this->db->update("message", $message);          
  }

  public function getMessageStream($userid)
  {
    $id1 = $this->session->userdata("userid");
    $id2 = $userid;

    $query = $this->db->query("SELECT * FROM message, user WHERE (sender = '".$id1."' AND receiver = '".$id2."' AND user.id = '".$id1."' AND showsender=1) OR (sender = '".$id2."' AND receiver = '".$id1."' AND user.id = '".$id2."' AND showreceiver=1) ORDER BY time ASC");
    foreach ($query->result() as $row)
    {
      $this->markAsRead($row->messageid);
    }
    return $query->result();
    }

    public function hideMessage($messageid)
    {
    $userid = $this->session->userdata("userid");
    $msg = $this->getMessage($messageid);
    if ($msg->sender == $userid)
    {
      $msg->showsender = 0;
    }
    else
    {
      $msg->showreceiver = 0;
    }
    $this->db->where("messageid", $msg->messageid);
    $this->db->update("message", $msg);
  }
  
// --------------------------------------------------------------------------------------------------------------------

  public function getNewMessageForm($receiver="")
  {
    $userid = $this->session->userdata("userid");
    
    $buffer  = "";
    $buffer .= form_open("newmessage");
    $buffer .= "<div id='mailstatus'></div>";
    if ($receiver == "")
    {
      $friends = $this->Friends_model->get_friends($userid);
      foreach($friends as $friend)
      {
        $receivers[$friend->id] = $friend->name;
      }
      $buffer .= form_dropdown("receiver", $receivers);
      $buffer .= br();      
    }
    else
    {
      $buffer .= form_input("receiver", $receiver);
      $buffer .= br();       
    }
    $buffer .= form_textarea("messagetext");
    $buffer .= br();
    $buffer .= form_button("sendmail","senden");
    $buffer .= form_close();
    return $buffer;  
  }


}
