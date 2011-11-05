<?php
class Friends extends CI_Controller {

	function index()
	{
		$this->load->view('base/top_bar');
		$this->load->view('friends/friends_mainview');
		$this->load->view('base/bottom_bar');
	}
}
?>