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
    $street = $this->input->post("street", true);
    $city = $this->input->post("city", true);
    $internet = $this->input->post("internet", true);
    $email = $this->input->post("email", true);
    $type = $this->input->post("type", true);
    $this->Location_model->addLocation($name, $lon, $lat, $street, $city, $type, $internet, $email);
    redirect('map/map');
  }
  
  public function getnewlocation()
  {
    if ($this->uri->segment(4))
    {
      $lon = $this->uri->segment(3);
      $lat = $this->uri->segment(4);
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
  }
  
  
  /*
   * localhost/location/id -> location_detail.php layout->view
   * localhost/map -> 2. seite -> location_mapdetail.php load->view
   * localhost/location/edit/id -> location_edit.php
   * 
   * 
   * $.post(2. url, function(data) {
   *   $("#detailview").html(data);
   * });
   */
  
  public function deletelocation($locid)
  {
    $this->Location_model->deleteLocation($locid);
  }
  
  
  public function getLocation()
  {
    if ($this->uri->segment(2))
    {
      $locid = $this->uri->segment(2);
      $data['location'] = $this->Location_model->getLocation($locid);
      $this->layout->view("location/location_details", $data);
    }
  }
  
  public function getLocationForMap()
  {
    if ($this->uri->segment(3))
    {
      $locid = $this->uri->segment(3);
      $data['location'] = $this->Location_model->getLocation($locid);
      $this->load->view('map/map_locationdetail', $data);
    }
  }
  
  public function edit()
  {
    if ($this->uri->segment(3))
    {
      $locid = $this->uri->segment(3);
      $data['location'] = $this->Location_model->getLocation($locid);
      $this->layout->view("location/location_edit", $data);
    }
  }


  
  public function updateLocation()
  {
    // if ($this->uri->segment(3))
    // {
      // $locid = $this->uri->segment(3);
      // $name = $this->input->post("name", true);
      // $street = $this->input->post("street", true);
      // $city = $this->input->post("city", true);
      // $internet = $this->input->post("internet", true);
      // $email = $this->input->post("email", true);
      // $type = $this->input->post("type", true);
      // $this->Location_model->updateLocation($locid, $name, $street, $city, $type, $internet, $email);
    // }
    redirect('map/map/index');
  }

}
?>