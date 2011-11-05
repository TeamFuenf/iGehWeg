<?php
class Friends extends CI_Controller {

	function index()
	{
		$current_user = "123";
		$data["friends"] = $this->get_friends($current_user);
		$data["current_user"] = "Hannes Köppel";
		$this->load->view("base/top_bar");
		$this->load->view("friends/friends_view", $data);
		$this->load->view("base/bottom_bar");
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