<?php

class Login_model extends CI_Model
{
    
	function __construct()
	{
		parent::__construct();
	}

	public function validate() {
		$this->db->where('name', $this->input->post('username'));
		$this->db->where('password', md5($this->input->post('password')));
		$query = $this->db->get('user');
		
		if($query->num_rows() == 1) {
			return $query;
		}
	}
	
	public function create_user() {
		$insert_data = array (
			'username' => $this->input->post('username'),
			'password' => md5($this->input->post('password')),
		);
		//Schaut ob der Benutzername schon vergeben ist
		$this->db->where('username', $this->input->post('username'));
		$query = $this->db->get('users');
		
		if($query->num_rows() > 0) { //vergeben
			return false;
		} else { //nicht vergeben, schreibt neuen User in DB
			$insert = $this->db->insert('users', $insert_data);
			return $insert;			
		}
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
