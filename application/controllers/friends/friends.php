<?php
class Friends extends CI_Controller {

	function index()
	{
		$current_user = "123";
		$data["friends"] = $this->get_friends($current_user);
		$data["current_user"] = "Hannes Köppel";
		$this->layout->view("friends/friends_view", $data);
	}
	
	function get_friends($current_user) 
	{
		$this->load->model('friends/friends_model');
		return $this->friends_model->get_friends($current_user);
	}
}
?>