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

	public function addLocation($name, $lon, $lat)
	{
		$this->db->
		$this->load->view('map/newlocationview');
	}
}
?>