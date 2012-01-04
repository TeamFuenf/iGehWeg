<?php
class Location extends CI_Controller {
	
  public function __construct()
  {
    parent::__construct();
    $this->load->model("location/Location_model");
  }

// --------------------------------------------------------------------------------------------------------------------

  // Normale Kartenansicht
  function index()
  {    
	$this->layout->view("map/map", $data);
  }

	public function addLocation()
	{
		$this->load->view('map/newlocationview');
	}
}
?>