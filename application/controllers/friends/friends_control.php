<?php
class Friends_control extends CI_Controller {

	function index()
	{
		$current_user = "123";
		
		$this->load->model('friends/friends_model');
		$current_user = $this->friends_model->get_user($current_user);
		
		$this->session->set_userdata('current_user', $current_user);
				
		//$this->get_friends();
		//$data["friends_main"] = $this->get_friends();
				
		$this->layout->view("friends/friends_view");
	}
	
	/*
	 * FRIENDS MAIN
	 */
	function get_friends() 
	{
		$this->load->model('friends/friends_model');
		//Hier werden die Freunde des aktuellen Users geholt
		$current_user = $this->session->userdata('current_user');
		$friends = $this->friends_model->get_friends($current_user->id);
		
		$this->load->model('friends/friends_format_model');
		//Hier werden die Daten formatiert
		$detail_string = $this->friends_format_model->format_friend_main($current_user, $friends);
		
		echo $detail_string;
		
	}
	
	/*
	 * FRIEND DETAIL
	 */
	function get_detail($detail_id) 
	{
		$this->load->model('friends/friends_model');
		//Hier werden die id, name und picture des Freundes geholt
		$details = $this->friends_model->get_user($detail_id);
		//Hier werden die Gruppen des Freundes geholt
		$groups = $this->friends_model->get_groups_with_friend("123", $detail_id);
		
		$this->load->model('friends/friends_format_model');
		//Hier werden die Daten formatiert
		$detail_string = $this->friends_format_model->format_friend_details($details, $groups);

		echo $detail_string;
	}
	
	/*
	 * ADD TO GROUP
	 */
	function get_groups($friend_id) 
	{
		$this->load->model('friends/friends_model');
		$groups_with_friend = $this->friends_model->get_groups_with_friend("123", $friend_id);
		$groups_without_friend = $this->friends_model->get_groups_without_friend("123", $friend_id);
		
		$this->load->model('friends/friends_format_model');
		//Hier werden die Daten formatiert
		$detail_string = $this->friends_format_model->format_add_to_group($groups_with_friend, $groups_without_friend, $friend_id);
		
		echo $detail_string;
	}

	/*
	 * ADD TO GROUP
	 */
	function add_groups($friend_id, $group_id) 
	{
		$this->load->model('friends/friends_model');
		$this->friends_model->add_to_group($group_id, $friend_id);
	}
		 
		
	/*
	 * DELETE FROM GROUP
	 */
	function del_groups($friend_id, $group_id) 
	{
		$this->load->model('friends/friends_model');
		$this->friends_model->delete_from_group($group_id, $friend_id);
	}
	
	/*
	 * DELETE FRIEND
	 */
	function del_friend($friend_id) 
	{
		$current_user = $this->session->userdata('current_user');
		$this->load->model('friends/friends_model');
		$this->friends_model->delete_friend($friend_id, $current_user->id);
	}
	
	/*
	 * ADD FRIEND MAIN
	 */
	function add_friends_main() 
	{
		$this->load->model('friends/friends_model');
		$users = $this->friends_model->get_all_users();
		
		$this->load->model('friends/friends_format_model');
		//Hier werden die Daten formatiert
		$data["detail_string"] = $this->friends_format_model->format_add_friends($users);
		
		$this->layout->view('friends/addfriend_view', $data);
	}
	
	/*
	 * ADD FRIEND
	 */
	function add_friend($friend_id) 
	{
		$current_user = $this->session->userdata('current_user');
		
		$this->load->model('friends/friends_model');
		$this->friends_model->add_friend($friend_id, $current_user->id);
	}
}
?>