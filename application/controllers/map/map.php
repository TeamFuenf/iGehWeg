<?php
class Map extends CI_Controller {
	
  public function __construct()
  {
    parent::__construct();
    $this->load->model("map/Map_model");
    $this->load->model("map/Marker_model");
  }

// --------------------------------------------------------------------------------------------------------------------

  // Normale Kartenansicht
  function index()
  {
	$data["markerLocations"] = $this->Marker_model->getLocations();
    $data["markerFriends"] = $this->Marker_model->getFriends();
    $data["markerEvents"] = $this->Marker_model->getEvents();
    
	$this->layout->view("map/map", $data);
  }



  // Kleine Karte mit Vorschau für eine Location
  function snippet()
  {
    $locationid = $this->uri->segment(3);
    $location = $this->Map_model->getLocation($locationid);
    
    $data["lon"] = $location["lon"];
    $data["lat"] = $location["lat"];    
    $this->load->view("map/snippet", $data);    
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