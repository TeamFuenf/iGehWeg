<?php
class Map extends CI_Controller {
	
	
	/*
	 * Scharfrichterhaus: lat='48.5748142' lon='13.4693767'
	 * 
	 * Aquarium: lat='48.5738242' lon='13.4635546'
	 * 
	 * Shamrock: lat='48.5755427' lon='13.4604024'
	 * 
	 */
	

	function index()
	{
		$this->load->view('map/mapview');
	}
	
	public function addLocation()
	{
		$this->load->view('map/newlocationview');
	}
	
	
	public function addCurrentPos()
	{
		$this->load->model('');
		$this->load->view('');
		
	}
	
	public function addAddress()
	{
		$this->load->model('');
		$this->load->view('');
		
	}
}
?>