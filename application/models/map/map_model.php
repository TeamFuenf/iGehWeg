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
        $data = array(
               'lon' => $lon,
               'lat' => $lat,
               'last_update' => date('j-m-y h-i-s')
            );
		$this->db->where('id', $id);
		$this->db->update('user', $data);
    }
      
}
