<?php

class Map_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

// --------------------------------------------------------------------------------------------------------------------

  public function getuser($userid)
  {
  $marker = "";
	$this->db->select('name, picture, lon, lat');
	$this->db->where('id', $userid);
	$query = $this->db->get('user');
	return $query->row();
  }

  public function getLocation($locationid)
  {
    $this->db->where("id", $locationid);
    $query = $this->db->get("location");
    return $query->row();
  }

  public function getAllLocations()
  {
    $query = $this->db->get("location");
    return $query->result();
  }
  
  /*
   * Aktualisiert die Geodaten (WGS84) für einen User in der Datenbank
   */
  public function updateUserGeo($userid, $lon, $lat)
  {
    $data["lon"] = $lon;
    $data["lat"] = $lat;
    $data["last_update"] = date("y-m-j h:i:s");
		$this->db->where("id", $userid);
		$this->db->update("user", $data);
  }
   
}
