<?php

class Friends_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    /**
     * Liefert die k nähesten Freunde inkl der Distanz in Metern zurück
     * 71.5 bzw. 111.3 = Länge bzw. Breite eines Längen- bzw. Breitengerades)
     */
    public function getKNearestFriends($k)
    {
      $userid = $this->session->userdata("userid");
      $sql = "
      SELECT user.*,
      ROUND(SQRT(
      POW(71.5 * (user.lon - (SELECT lon FROM user WHERE user.id = '".$userid."')),2) + 
      POW(111.3 * (user.lat - (SELECT lat FROM user WHERE user.id = '".$userid."')),2)) * 1000) as distance
      FROM user, friend
      WHERE friend.id = '".$userid."'
      AND friend.friendid = user.id
      ORDER BY distance
      LIMIT ".$k."
      ";
      $query = $this->db->query($sql);
      return $query->result();
    }

    /**
	 * Gibt die Daten eines Benutzers zurück.
	 */
    function get_user($user_id) 
    {
      	$this->db->where("id", $user_id);      
    	$query = $this->db->get("user");
		return $query->row();
    }
	
	/**
	 * Gibt die Daten aller vorhandenen Benutzer zurück.
	 * 
	 */
    function get_all_users() 
    {      
    	$query = $this->db->get("user");
		  return $query->result();
    }
	
	/**
	 * Gibt alle Benutzer exklusiver der Freunde eines Benutzer mit einer bestimmten ID zurück.
	 * 
	 */
    function get_all_users_without_friends($user_id) 
    {      
    	$query = $this->db->query("SELECT * FROM user WHERE user.id <> '".$user_id."' AND user.id NOT IN (SELECT friendid FROM friend WHERE id = '".$user_id."');");
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
	 * Funktion für die Benutzersuche beim Freunde hinzufügen.
	 * Durchsucht alle Benutzer ohne die Freunde des suchenden Benutzers.
	 * 
	 */
    function search_users_without_friends($user_id, $input) 
    {      
    	$query = $this->db->query("SELECT * FROM user WHERE user.id <> '".$user_id."' AND user.name LIKE '%".$input."%' AND user.id NOT IN (SELECT friendid FROM friend WHERE id = '".$user_id."');");
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
	 * Gibt alle Freunde eines Benutzers zurück.
	 * 
	 */
    function get_friends($user_id) 
    {	  
	  $this->db->where("friend.id", $user_id);
      $this->db->from("friend");
      $this->db->join("user", "user.id = friend.friendid");
      $query = $this->db->get();
      return $query->result();
    } 

	/**
	 * Fügt einen Freund zur Freundesliste eines Benutzers hinzu.
	 * 
	 */
	function add_friend($friend_id, $user_id) 
	{
		$this->db->query("INSERT INTO friend (friendid, id) VALUES ('".$friend_id."', '".$user_id."');");
	}
	
	/**
	 * Löscht Freund aus der Freundesliste eines Benutzers.
	 * 
	 */
	function delete_friend($friend_id, $user_id) 
	{
		$this->db->query("DELETE FROM friend WHERE id = '".$user_id."' AND friendid = '".$friend_id."';");
		$this->db->query("DELETE FROM group_member WHERE memberid = '".$friend_id."';");
	}
	
	/**
	 * Gibt alle vorhandenen Gruppen eines Benutzers zurück.
	 * 
	 */
	function get_groups($user_id) 
	{
		$query = $this->db->query("SELECT * FROM `groups` WHERE userid = '".$user_id."';");
		
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
	 * Gibt alle Gruppen eines Benutzers zurück in dem sich ein bestimmter Freund (anderer Benutzer) befindet.
	 */
	function get_groups_with_friend($user_id, $friend_id) 
	{
		$query = $this->db->query("SELECT * FROM group_member LEFT JOIN `groups` ON `groups`.id = group_member.groupid WHERE `groups`.userid = '".$user_id."' AND group_member.memberid = '".$friend_id."';");
		
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
	 * Gibt alle Gruppen eines Benutzers zurück in dem sich ein bestimmter Freund (anderer Benutzer) NICHT befindet.
	 */
	function get_groups_without_friend($user_id, $friend_id) 
	{
		$query = $this->db->query("SELECT * FROM groups WHERE userid = '".$user_id."' AND id NOT IN ( SELECT groupid FROM group_member WHERE memberid = '".$friend_id."' )");
		
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
	 * Gibt alle Mitglieder einer Gruppe zurück.
	 */
	function get_group_members($group_id) 
	{
		$query = $this->db->query("SELECT gm.memberid, u.name, u.picture FROM group_member AS gm, user AS u WHERE gm.memberid = u.id AND groupid = '".$group_id."';");
		
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
	 * Erstellt eine neue Gruppe für einen Benutzer.
	 * 
	 */
	function create_group($group_name, $user_id) 
	{
			$this->db->query("INSERT INTO `groups` (userid, name) VALUES ('".$user_id."', '".$group_name."');");
	}
	
	/**
	 * Löscht eine bestimmte Gruppe.
	 * 
	 */
	function delete_group($group_id) 
	{
		$this->db->query("DELETE FROM `groups` WHERE id = '".$group_id."';");
		$this->db->query("DELETE FROM `group_member` WHERE groupid = '".$group_id."';");
	}
	
	/**
	 * Fügt einen Freund aus der Freundesliste des Benutzers zu einer Gruppe hinzu.
	 * 
	 */
	function add_to_group($group_id, $friend_id) 
	{
		$query = $this->db->query("SELECT * FROM `group_member` WHERE groupid = '".$group_id."' AND memberid = '".$friend_id."';");
		
		if($query->num_rows() == 0) 
		{
			$this->db->query("INSERT INTO group_member (groupid, memberid) VALUES ('".$group_id."', '".$friend_id."');");
		}
	}
	
	/**
	 * Löscht einen Freund aus einer Gruppe.
	 * 
	 */
	function delete_from_group($group_id, $friend_id) 
	{
		$query = $this->db->query("SELECT * FROM `group_member` WHERE groupid = '".$group_id."' AND memberid = '".$friend_id."';");
		
		if($query->num_rows() != 0) 
		{
			$this->db->query("DELETE FROM group_member WHERE groupid = '".$group_id."' AND memberid = '".$friend_id."';");
		}
	}
}

?>
