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
      $lon = $row->lon;
	  $lat = $row->lat;
	  $id = $row->id;
	  $name = $row->name;
	  $bla = $this->createLocationMarker($lon, $lat, $id, $name);
      $marker .= "".$bla."\n";
      //$markername = "location".$row->id;
      //$marker .= "var ".$markername." = new OpenLayers.Marker(new OpenLayers.LonLat(".$row->lon.", ".$row->lat.").transform(fromProj, toProj), locationIcon.clone());";
      //$marker .= "locations.addMarker(".$markername.");";         
    }

    return $marker;
  }
  
  public function createLocationMarker($lon, $lat, $id, $name)
  {
	$marker = "";
	$marker .= "var lonLatMarker".$id." = new OpenLayers.LonLat(".$lon.", ".$lat.").transform(fromProj,  toProj);";
    $marker .= "var feature = new OpenLayers.Feature(locations, lonLatMarker".$id.");";
    $marker .= "feature.closeBox = true;";
    $marker .= "feature.popupClass = OpenLayers.Class(OpenLayers.Popup.AnchoredBubble, {minSize: new OpenLayers.Size(150, 90) } );";
    $marker .= "feature.data.popupContentHTML = '".$id."';";
    $marker .= "feature.data.overflow = 'hidden';";

    $marker .= "var marker = new OpenLayers.Marker(lonLatMarker".$id.", locationIcon.clone());";
    $marker .= "marker.feature = feature;";
	$marker .= "var markerClick = function(evt) {";
    $marker .= "if (this.popup == null) {";
    $marker .= "        this.popup = this.createPopup(this.closeBox);";
    $marker .= "        map.addPopup(this.popup);";
    $marker .= "            this.popup.show();";
    $marker .= "        } else {";
    $marker .= "            this.popup.toggle();";
    $marker .= "        }";
    $marker .= "        OpenLayers.Event.stop(evt);";
    $marker .= "};";
    $marker .= "marker.events.register('mousedown', feature, markerClick);";

    $marker .= "locations.addMarker(marker);";
    
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
		
		$marker .= "var friendIcon".$id." = new OpenLayers.Icon('";
		$marker .= $picture;
		$marker .= "', friendIconSize, friendIconOffset);";
		$marker .= "\n";
		$marker .= "var friend".$id." = new OpenLayers.Marker(new OpenLayers.LonLat(";
		$marker .= $lon.", ".$lat.").transform(fromProj, toProj), friendIcon".$id.");";
		$marker .= "\n";
		$marker .= "friends.addMarker(friend".$id.");";
		$marker .= "\n";
		
		//noch ohne Sinn, wichtig für die Popups
		$freunde .= $friend->last_update;
		$freunde .= $friend->name;
	}
    return $marker;
  }

  public function getEventsIcons()
  {
    $marker = "";
    return $marker;
  }

}
