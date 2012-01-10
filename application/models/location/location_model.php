<?php

class Location_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

// --------------------------------------------------------------------------------------------------------------------

  public function addLocation($name, $lon, $lat, $street, $city)
  {
  	$this->db->set('id', uniqid('location', true));
    $this->db->set('name', $name);
	$this->db->set('lon', $lon);
    $this->db->set('lat', $lat);
	$this->db->set('street', $street);
	$this->db->set('city', $city);
    $this->db->insert('location');
  }
      
}
