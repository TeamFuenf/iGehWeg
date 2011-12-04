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
      
}
