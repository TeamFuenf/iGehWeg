<?php
class Location extends CI_Controller {
	
  public function __construct()
  {
    parent::__construct();
	parent::is_logged_in();
    $this->load->model("location/Location_model");
  }

// --------------------------------------------------------------------------------------------------------------------

  // Normale Kartenansicht
  function index()
  {    
	$this->layout->view("map/map", $data);
  }

  public function add()
  {
    $name = $this->input->post("name", true);
    $lon = $this->input->post("lon", true);
    $lat = $this->input->post("lat", true);
    $adress = $this->input->post("adress", true);
    $city = $this->input->post("city", true);
    $this->Location_model->addLocation($name, $lon, $lat, $adress, $city);
    redirect('/map', 'refresh');
  }
  
  public function getnewlocation($lon, $lat)
  {
    echo '{
      "type": "FeatureCollection", 
      "features": [
        {
          "type": "Feature",
          "id": "0815",
          "properties": {
            "name": "Neue Location"
          },
          "geometry": {
            "type": "Point",
            "coordinates": ['.$lon.', '.$lat.']
          }
        },
      {}
    ]}';
  }
  
  // public function getnewlocation()
  // {
    // echo '{
      // "type": "FeatureCollection", 
      // "features": [
        // {
          // "type": "Feature",
           // "id": "'.$loc->id.'",
          // "properties": {
            // "name": "'.$loc->name.'"
          // },
          // "geometry": {
            // "type": "Point",
            // "coordinates": ['.$loc->lon.', '.$loc->lat.']
          // }
        // },
      // {}
    // ]}';
  // }
}
?>