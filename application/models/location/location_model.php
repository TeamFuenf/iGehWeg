<?php

class Location_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

// --------------------------------------------------------------------------------------------------------------------

  public function addLocation($name, $lon, $lat, $street, $city, $type, $internet, $email)
  {
    $this->db->set('id', uniqid('location', true));
    $this->db->set('name', $name);
    $this->db->set('lon', $lon);
    $this->db->set('lat', $lat);
    $this->db->set('street', $street);
    $this->db->set('city', $city);
    $this->db->set('type', $type);
    $this->db->set('internet', $internet);
    $this->db->set('email', $email);
    $this->db->insert('location');
  }
  
  
  public function deleteLocation($locid)
  {
    $this->db->where('id', $locid);
    $this->db->delete('location'); 
  }
  
  
  public function getLocation($locid)
  {
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
  
  public function updateLocation($id, $name, $street, $city, $type, $internet, $email)
  {
    $data = array(
      'name' => $name,
      'street' => $street,
      'city' => $city,
      'type' => $type,
      'internet' => $internet,
      'email' => $email
    );
    $this->db->where('id', $id);
    $this->db->update('location', $data);
  }
  
}
