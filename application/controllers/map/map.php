<?php
class Map extends CI_Controller {
	
  public function __construct()
  {
    parent::__construct();
    $this->load->model("map/Marker_model");
  }

	function index()
	{
	  $data["markerLocations"] = $this->Marker_model->getLocations();
    $data["markerFriends"] = $this->Marker_model->getFriends();
    $data["markerEvents"] = $this->Marker_model->getEvents();
    
		$this->layout->view("map/mapview", $data);
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