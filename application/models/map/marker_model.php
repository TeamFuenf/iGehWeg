<?php

class Marker_model extends CI_Model
{
    
  function __construct()
  {
    parent::__construct();
  }
  
  public function getUserIcon($userid)
  {
  	$marker = "";
	$this->db->select('name, picture, lon, lat');
	$this->db->where('id', $userid);
	$query = $this->db->get('user');
	$result = $query->row();
	$lon = $result->lon;
	$lat = $result->lat;
	$picture = $result->picture;
	$name = $result->name;
	
	return $this->createUserIcon($name, $lon, $lat, $picture);
  }
  
  public function getFriendsIcons($friends)
  {
  	$marker = "";
	$freunde = "";
	
	foreach ($friends as $friend) {
		$id = $friend->id;
		$lon = $friend->lon;
		$lat = $friend->lat;
		$picture = $friend->picture;
		$name = $friend->name;
		
		// noch ohne sinn, noch wichtig für die eventuelle Anzeige
		//$lastupdate.= $friend->last_update;
		
		$marker .= $this->createUserIcon($name, $lon, $lat, $picture);
		$marker .= "\n";
		// $marker .= "var friendIcon = new OpenLayers.Icon('";
		// $marker .= $picture;
		// $marker .= "', friendIconSize, friendIconOffset);";
		// $marker .= "\n";
		// $marker .= "var friend = new OpenLayers.Marker(new OpenLayers.LonLat(";
		// $marker .= $lon.", ".$lat.").transform(fromProj, toProj), friendIcon);";
		// $marker .= "\n";
		// $marker .= "friends.addMarker(friend);";
		// $marker .= "\n";
		
		//noch ohne Sinn, wichtig für die Popups
	}
    return $marker;
  }
  
  private function createUserIcon($name, $lon, $lat, $picture)
  {
  	// $marker .= "var friendIcon = new OpenLayers.Icon('";
	// $marker .= $picture;
	// $marker .= "', friendIconSize, friendIconOffset);";
	// $marker .= "\n";
	// $marker .= "var friend = new OpenLayers.Marker(new OpenLayers.LonLat(";
	// $marker .= $lon.", ".$lat.").transform(fromProj, toProj), friendIcon);";
	// $marker .= "\n";
	// $marker .= "friends.addMarker(friend);";
	// $marker .= "\n";
	
	
		$marker = "";
	$marker .= "var lonLatMarker = new OpenLayers.LonLat(".$lon.", ".$lat.").transform(fromProj,  toProj);";
    $marker .= "var feature = new OpenLayers.Feature(users, lonLatMarker);";
    $marker .= "feature.closeBox = true;";
    $marker .= "feature.popupClass = OpenLayers.Class(OpenLayers.Popup.AnchoredBubble, {autoSize: true, closeOnMove: true, keepInMap: true } );";
    $marker .= "feature.data.popupContentHTML = '".addslashes($name)."';";
    $marker .= "feature.data.overflow = 'hidden';";
	$marker .= "var userIcon = new OpenLayers.Icon('".$picture."', userIconSize, userIconOffset);";
    $marker .= "var marker = new OpenLayers.Marker(lonLatMarker, userIcon);";
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
	$marker .= "marker.events.register('touchend', feature, markerClick);";

    $marker .= "users.addMarker(marker);";
    
    return $marker;
	
	
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
      $marker .= "".$this->createLocationMarker($lon, $lat, $id, $name)."\n";
      //$markername = "location".$row->id;
      //$marker .= "var ".$markername." = new OpenLayers.Marker(new OpenLayers.LonLat(".$row->lon.", ".$row->lat.").transform(fromProj, toProj), locationIcon.clone());";
      //$marker .= "locations.addMarker(".$markername.");";         
    }

    return $marker;
  }
  
  private function createLocationMarker($lon, $lat, $id, $name)
  {
	$marker = "";
	$marker .= "var lonLatMarker = new OpenLayers.LonLat(".$lon.", ".$lat.").transform(fromProj,  toProj);";
    $marker .= "var feature = new OpenLayers.Feature(locations, lonLatMarker);";
    $marker .= "feature.closeBox = true;";
    $marker .= "feature.popupClass = OpenLayers.Class(OpenLayers.Popup.AnchoredBubble, {autoSize: true, closeOnMove: true, keepInMap: true } );";
    $marker .= "feature.data.popupContentHTML = '".addslashes($name)."';";
    $marker .= "feature.data.overflow = 'hidden';";

    $marker .= "var marker = new OpenLayers.Marker(lonLatMarker, locationIcon.clone());";
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
	$marker .= "marker.events.register('touchend', feature, markerClick);";

    $marker .= "locations.addMarker(marker);";
    
    return $marker;
  }
    
  

  public function getEventsIcons()
  {
    $marker = "";
    return $marker;
  }

}
