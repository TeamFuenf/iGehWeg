<?php
class Map extends CI_Controller {
	
  public function __construct()
  {
    parent::__construct();
	parent::is_logged_in();
    $this->load->model("map/Map_model");
    $this->load->model("map/Marker_model");
	$this->load->model("friends/Friends_model");
  }

// --------------------------------------------------------------------------------------------------------------------

  // Normale Kartenansicht
  function index()
  {
    $userid = $this->session->userdata("userid");
	
	$friends = $this->Friends_model->get_friends($userid);
	$data["markerUser"] = $this->Marker_model->getUserIcon($userid);
	$data["markerFriends"] = $this->Marker_model->getFriendsIcons($friends);
	$data["markerLocations"] = $this->Marker_model->getLocationsIcons();
    $data["markerEvents"] = $this->Marker_model->getEventsIcons();
    
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
	
	public function showLocationDetails($locationID)
	{
		
	}
	
}
?>