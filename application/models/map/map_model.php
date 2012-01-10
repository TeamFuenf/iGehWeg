<?php

class Map_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

// --------------------------------------------------------------------------------------------------------------------

  public function getLocation($locationid)
  {
    $this->db->where("id", $locationid);
    $query = $this->db->get("location");
    return $query->row_array();
  }
  
  function updateUserGeo($userid, $lon, $lat)
  {
    $data["lon"] = $lon;
    $data["lat"] = $lat;
    $data["last_update"] = date("y-m-j h:i:s");
		$this->db->where("id", $userid);
		$this->db->update("user", $data);
  }
      
}
