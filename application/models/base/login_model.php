<?php

class Login_model extends CI_Model
{
    
	function __construct()
	{
		parent::__construct();
	}
	
	/* 
	 * Validiert beim Login den eingegebenen Benutzernamen und das Passwort.
	 * Benutzername und Passwort werden per HTTP-Post übergeben.
	 * Wenn der Benutzername vorhanden ist und das zugehörige Passwort übereinstimmt, dann werden
	 * die Daten des Benutzers zurückgegeben. 
	 */
	public function validate() {
		$this->db->where('name', $this->input->post('username'));
		$this->db->where('password', md5($this->input->post('password')));
		$query = $this->db->get('user');
		
		if($query->num_rows() == 1) {
			return $query->result();
		}
	}
	
	/*
	 * Legt einen neuen Benutzer mit übergebenem Benutzernamen, Passwort und ID an.
	 */
	public function create_user($userid, $username, $password) {
    $insert_data["id"] = $userid;
		$insert_data["name"] = $username;
		$insert_data["password"] = md5($password);

		//Schaut ob der Benutzername schon vergeben ist
		$this->db->where("name", $username);
		$query = $this->db->get("user");
		
		if($query->num_rows() > 0) { //vergeben
			return false;
		} else { //nicht vergeben, schreibt neuen User in DB
			$insert = $this->db->insert("user", $insert_data);
			return $insert;			
		}
	}

	/*
	 * Testfunktion zum Wechseln der Benutzer ohne Login.
	 * Wird in der Final-Version nicht verwendent.
	 */
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
