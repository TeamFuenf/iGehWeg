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
  
  
  public function deleteLocation($locid)
  {
    $this->db->where('id', $locid);
    $this->db->delete('location'); 
  }
  
  
  public function getLocation($locid)
  {
    //$this->db->select('name', 'type', 'street', 'city', 'internet', 'email');
    $this->db->where('id', $locid);
    $query = $this->db->get('location');
    return $query->row();
  }
  
  
  public function getLocationComments($locid)
  {
    $this->db->select();
    $this->db->where('locationid', $locid);
    $query = $this->db->get('location_comment');
  }
  
  
  public function getLocationInfo($locid)
  {
    $this->db->select();
    $this->db->where('locationid', $locid);
    $query = $this->db->get('location_info');
  }
  
  
  public function getLocationRating($locid)
  {
    $this->db->select();
    $this->db->where('locationid', $locid);
    $query = $this->db->get('location_rating');
  }
  
}
