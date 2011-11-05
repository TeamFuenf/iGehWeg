<?php

class Friends_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function get_friends($current_user) 
    {
    	$query = $this->db->query("SELECT u.id, u.name, u.picture FROM user AS u, friend AS f WHERE u.id = f.friendid AND f.id=".$current_user);
		
		foreach ($query->result() as $row)
		{
			$ids[] = $row->id;
		   	$names[] = $row->name;
			$pics[] = $row->picture;
		}	
		
		return array("friend_names" => $names, "friend_ids" => $ids, "friend_pics" => $pics);
    } 
    
}

?>
