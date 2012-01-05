<?php

class Marker_model extends CI_Model
{
    
  function __construct()
  {
    parent::__construct();
  }

  public function getLocationsIcons()
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
    
  public function getFriendsIcons($friends)
  {
  	$marker = "";
  	$this->load->model("friends/friends_model");
	// hole alle Freunde und iteriere sie durch und füge sie dem $marker hinzu
	
	$freunde = "";
	
	foreach ($friends as $friend) {
		$id = $friend->id;
		$lon = $friend->lon;
		$lat = $friend->lat;
		$picture = $friend->picture;
		
		$marker .= "var friendIcon" . $id. " = new OpenLayers.Icon('";
		$marker .= $picture;
		$marker .= "', friendIconSize, friendIconOffset);";
		$marker .= "\n";
		$marker .= "var friend".$id." = new OpenLayers.Marker(new OpenLayers.LonLat(" .$lon.", ".$lat.").transform(fromProj, toProj), friendIcon".$id.");";
		$marker .= "\n";
		$marker .= "friends.addMarker(friend".$id.");";
		$marker .= "\n";
		
		$freunde .= $friend->last_update;
		$freunde .= $friend->name;
	}
	

	
  	//$marker .= "";
	
    
	/*
    $marker .= "var friendIcon123 = new OpenLayers.Icon('../helper/images/user/marker/123', friendIconSize, friendIconOffset);";
	$marker .= "\n";
    $marker .= "var friend123 = new OpenLayers.Marker(new OpenLayers.LonLat(13.4454215, 48.5631164).transform(fromProj, toProj), friendIcon123);";
	$marker .= "\n";
    $marker .= "friends.addMarker(friend123);";
	$marker .= "\n";

	$marker .= "var friendIcon124 = new OpenLayers.Icon('../helper/images/user/marker/124', friendIconSize, friendIconOffset);";
	$marker .= "\n";
    $marker .= "var friend124 = new OpenLayers.Marker(new OpenLayers.LonLat(13.4632595, 48.5732856).transform(fromProj, toProj), friendIcon124);";
    $marker .= "\n";
    $marker .= "friends.addMarker(friend124);";
	$marker .= "\n";
	
	$marker .= "var friendIcon125 = new OpenLayers.Icon('../helper/images/user/marker/125', friendIconSize, friendIconOffset);";
	$marker .= "\n";
    $marker .= "var friend125 = new OpenLayers.Marker(new OpenLayers.LonLat(13.4672211, 48.5744110).transform(fromProj, toProj), friendIcon125);";
    $marker .= "\n";
    $marker .= "friends.addMarker(friend125);";
	$marker .= "\n";
*/
    return $marker;
  }

  public function getEventsIcons()
  {
    $marker = "";
    return $marker;
  }

}
