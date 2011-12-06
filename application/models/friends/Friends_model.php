<?php

class Friends_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

	/**
	 * Holt einen Benutzer.
	 * 
	 * <- $user_id
	 * -> Objekt mit id, name und picture
	 */
    function get_user($user_id) 
    {
      $this->db->where("id", $user_id);      
    	$query = $this->db->get("user");
		  return $query->row();
    }

	/**
	 * Holt alle Freunde eines Benutzeres.
	 * 
	 * <- $user_id
	 * -> $data Array mit allen Freunden mit id, name und picture
	 */
    function get_friends($user_id) 
    {
    	$query = $this->db->query("SELECT u.id, u.name, u.picture FROM user AS u, friend AS f WHERE u.id = f.friendid AND f.id=".$user_id);
		
		if($query->num_rows() > 0) 
		{
			foreach ($query->result() as $row)
			{
				$data[] = $row;
			}	
			
			return $data;
		}
    } 

	/**
	 * Fügt Freund zur Freundesliste eines Benutzers.
	 * 
	 * <- $friend_id, $user_id
	 * -> nix
	 */
	function add_friend($friend_id, $user_id) 
	{
		$this->db->query("INSERT INTO friend ('friendid', 'id') VALUES ('".$friend_id."', '".$user_id."');");
	}
	
	/**
	 * Löscht Freund aus der Freundesliste eines Benutzers.
	 * 
	 * <- $friend_id, $user_id
	 * -> nix
	 */
	function delete_friend($friend_id, $user_id) 
	{
		$this->db->query("DELETE FROM friend WHERE id = '".$user_id."' AND friendid = '".$friend_id."';");
	}
	
	/**
	 * Holt alle Gruppen des eines Benutzeres.
	 * 
	 * <- $user_id
	 * -> $data Array mit allen Gruppen mit id, name
	 */
	function get_groups($user_id) 
	{
		$query = $this->db->query("SELECT * FROM `group` WHERE userid = '".$user_id."';");
		
		if($query->num_rows() > 0) 
		{
			foreach($query->result() as $item) 
			{
				$data[] = $item;
			}
			
			return $data;
		}	
	}
	
	/**
	 * Holt alle Mitglieder einer Gruppen.
	 * 
	 * <- $group_id
	 * -> $data Array mit allen Mitgliedern einer Gruppe mit id, name und picture
	 */
	function get_group_members($group_id) 
	{
		$query = $this->db->query("SELECT u.id, u.name, u.picture FROM group AS g, user AS u WHERE g.id = '".$group_id."' AND g.friendid = u.id;");
		
		if($query->num_rows() > 0) 
		{
			foreach($query->result() as $item) 
			{
				$data[] = $item;
			}
			
			return $data;
		}		
	}
	
	/**
	 * Erstellt Gruppe für einen Benutzer.
	 * 
	 * <- $group_name, $user_id
	 * -> nix
	 */
	function create_group($group_name, $user_id) 
	{
		$query = $this->db->query("SELECT * FROM `group` WHERE name = '".$group_name."' AND userid = '".$user_id."';");
		
		if($query->num_rows() == 0) 
		{
			$this->db->query("INSERT INTO `group` ('userid', 'name') VALUES ('".$user_id."', '".$group_name."');");
		}		
	}
	
	/**
	 * Löscht Gruppe.
	 * 
	 * <- $group_id
	 * -> nix
	 */
	function delete_group($group_id) 
	{
		$this->db->query("DELETE FROM `group` WHERE id = '".$group_id."';");
	}
	
	/**
	 * Fügt Freund aus der Freundesliste des aktuellen Benutzers zu einer Gruppe hinzu.
	 * 
	 * <- $group_id, $friend_id
	 * -> nix
	 */
	function add_to_group($group_id, $friend_id) 
	{
		$query = $this->db->query("SELECT userid, name FROM `group` WHERE id = '".$group_id."';");
		
		if($query->num_rows() > 0) 
		{
			foreach($query->result() as $item) 
			{
				$data[] = $item;
			}
			
			$this->db->query("INSERT INTO `group` ('userid', 'friendid', 'name') VALUES ('".$data[0]->userid."', '".$friend_id."', '".$data[0]->name."');");
		}
	}
	
	/**
	 * Löscht Freund aus einer Gruppe.
	 * 
	 * <- $group_id, $friend_id
	 * -> nix
	 */
	function delete_from_group($group_id, $friend_id) 
	{
		$query = $this->db->query("SELECT userid, name FROM `group` WHERE id = '".$group_id."';");
		
		if($query->num_rows() > 0) 
		{
			foreach($query->result() as $item) 
			{
				$data[] = $item;
			}
			
			$this->db->query("DELETE FROM `group` WHERE name = '".$data[0]->name."' AND userid = '".$data[0]->userid."' AND friendid = '".$friend_id."';");
		}	
	}
}

?>
