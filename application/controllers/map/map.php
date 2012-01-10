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

  function getlocations()
  {
    echo '{
      "type": "FeatureCollection", 
      "features": [
    ';
    $locations = $this->Map_model->getAllLocations();
    foreach ($locations as $loc)
    {
      echo '
        {
          "type": "Feature",
          "id": "'.$loc->id.'",
          "properties": {
            "name": "'.$loc->name.'"
          },
          "geometry": {
            "type": "Point",
            "coordinates": ['.$loc->lon.', '.$loc->lat.']
          }
        },
      ';
    }
    echo "{}";
    echo ']}';
  }
  
  function test()
  {
    echo '
{
  "type": "FeatureCollection", 
  "features": [
  {
    "type": "Feature",
    "id": "Aran",
    "properties": {
      "name": "Aran",
      "typ": "location"
    },
    "geometry": {
      "type": "Point",
      "coordinates": [13.455559015274048, 48.57214772552424]
    }
  },
  {
    "type": "Feature",
    "id": "Aquarium",
    "properties": {
      "name": "Aquarium",
      "typ": "location"
    },
    "geometry": {
      "type": "Point",
      "coordinates": [13.46351444721222, 48.57376876026612]
    }
  }
  ]
}
';
  }
  
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