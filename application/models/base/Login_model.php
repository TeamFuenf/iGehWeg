<?php

class Login_model extends CI_Model
{
    
  function __construct()
  {
    parent::__construct();
    $this->load->helper("form");
  }

  public function getUsers()
  {
    $users = array();
    $buffer  = "";

    $query = $this->db->get("user");
    foreach ($query->result() as $row)
    {
      $users[$row->id] = $row->name;
    }
    
    $activeuser = $this->session->userdata("userid");
    $buffer .= form_open("base/login");
    $buffer .= form_dropdown("userid", $users, $activeuser);
    $buffer .= form_submit("login", "User wechseln");
    $buffer .= form_close();
    return $buffer;        
  }
  
}
