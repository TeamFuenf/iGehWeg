<?php
class Friends_control extends CI_Controller {

	function index()
	{
		$current_user = "123";
		
		$this->load->model('friends/friends_model');
		$current_user = $this->friends_model->get_user($current_user);
				
		$data["friends_main"] = $this->get_friends($current_user);
				
		$this->layout->view("friends/friends_view", $data);
	}
	
	/*
	 * FRIENDS MAIN
	 */
	function get_friends($current_user) 
	{
		$this->load->model('friends/friends_model');
		//Hier werden die Freunde des aktuellen Users geholt
		$friends = $this->friends_model->get_friends($current_user[0]->id);
		
		$this->load->model('friends/friends_format_model');
		//Hier werden die Daten formatiert
		$detail_string = $this->friends_format_model->format_friend_main($current_user[0], $friends);
		
		return $detail_string;
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
		$groups = $this->friends_model->get_groups($detail_id);
		
		$this->load->model('friends/friends_format_model');
		//Hier werden die Daten formatiert
		$detail_string = $this->friends_format_model->format_friend_details($details[0], $groups);

		echo $detail_string;
	}
}
?>