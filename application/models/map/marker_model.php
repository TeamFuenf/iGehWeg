<?php

class Marker_model extends CI_Model
{
    
  function __construct()
  {
    parent::__construct();
  }

  public function getLocations()
  {
    $marker = "";
    
    $query = $this->db->get("location");
    foreach ($query->result() as $row)
    {
      $markername = "location".$row->id;
      $marker .= "var ".$markername." = new OpenLayers.Marker(new OpenLayers.LonLat(".$row->lon.", ".$row->lat.").transform(fromProj, toProj), locationicon.clone());";
      $marker .= "locations.addMarker(".$markername.");";         
    }

    return $marker;
  }
    
  public function getFriends()
  {
    $marker = "";

    $marker .= "var friend123 = new OpenLayers.Marker(new OpenLayers.LonLat(13.4454215, 48.5631164).transform(fromProj, toProj), friendIcon123);";
    $marker .= "friends.addMarker(friend123);";
    $marker .= "var friend124 = new OpenLayers.Marker(new OpenLayers.LonLat(13.4632595, 48.5732856).transform(fromProj, toProj), friendIcon124);";
    $marker .= "friends.addMarker(friend124);";
    $marker .= "var friend125 = new OpenLayers.Marker(new OpenLayers.LonLat(13.4672211, 48.5744110).transform(fromProj, toProj), friendIcon125);";
    $marker .= "friends.addMarker(friend125);";

    return $marker;
  }

  public function getEvents()
  {
    $marker = "";
    return $marker;
  }

}
