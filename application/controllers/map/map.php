<?php
class Map extends CI_Controller {
	
  public function __construct()
  {
    parent::__construct();
    parent::is_logged_in();
    $this->load->model("map/Map_model");
    $this->load->model("friends/Friends_model");
    $this->load->model("event/Event_model");
    $this->load->model("location/location_model");
  }
  
  
  // Normale Kartenansicht
  public function index()
  {
    $data["layer"]["locations"] = $this->getLayerVisibility("locations");
    $data["layer"]["friends"] = $this->getLayerVisibility("friends");
    $data["layer"]["events"] = $this->getLayerVisibility("events");
    $data["layer"]["buslinie1"] = $this->getLayerVisibility("buslinie1");
    $data["layer"]["buslinie2"] = $this->getLayerVisibility("buslinie2");
    $data["layer"]["buslinie5"] = $this->getLayerVisibility("buslinie5");
    $data["layer"]["buslinie6"] = $this->getLayerVisibility("buslinie6");
    $data["layer"]["buslinie7"] = $this->getLayerVisibility("buslinie7");
    $data["layer"]["buslinie8"] = $this->getLayerVisibility("buslinie8");
    $data["layer"]["buslinie9"] = $this->getLayerVisibility("buslinie9");    
    $this->layout->view("map/map", $data);
  }  
  
  public function sess()
  {
    echo "<pre>";
    print_r($this->session->all_userdata());    
  }
  
  // Kleine Karte mit Vorschau für eine Location
  public function snippet()
  {
    $locationid = $this->uri->segment(3);
    $location = $this->Map_model->getLocation($locationid);
    
    $data["lon"] = $location["lon"];
    $data["lat"] = $location["lat"];    
    $this->load->view("map/snippet", $data);    
  }
  
// --------------------------------------------------------------------------------------------------------------------

  public function saveLayerVisibility()
  {
    $layer = $this->input->post("layer", true);
    $visibility = $this->input->post("visibility", true);  
    $this->session->set_userdata("layer_".$layer, $visibility);
    echo $layer." -> ".$visibility;
  }

  public function loadLayerVisibility()
  {
    $layer = $this->input->post("layer", true);
    return $this->getLayerVisibility($layer);
  }
  
  private function getLayerVisibility($layer)
  {
    if ($this->session->userdata("layer_".$layer))
    {
      return $this->session->userdata("layer_".$layer);
    }
    else
    {
      return "false";      
    }    
  }
  
// --------------------------------------------------------------------------------------------------------------------

  /**
   * Liefert alle eingetragenen Locations im GeoJSON Format zur Anzeige in der Kartenansicht
   */
  public function getlocations()
  {
    echo '{
      "type": "FeatureCollection", 
      "features": [
    ';
    $locations = $this->Map_model->getAllLocations();
    foreach ($locations as $loc)
    {
      echo '
        {
          "type": "Feature",
          "id": "'.$loc->id.'",
          "properties": {
            "name": "'.$loc->name.'",
            "id": "'.$loc->id.'"
          },
          "geometry": {
            "type": "Point",
            "coordinates": ['.$loc->lon.', '.$loc->lat.']
          }
        },
      ';
    }
    echo "{}";
    echo ']}';
  }
  
  /**
   * Liefert alle Freunde des Nutzers inkl. Position im GeoJSON Format zur Anzeige in der Kartenansicht
   */
  public function getfriends()
  {
    $userid = $this->session->userdata("userid");
    echo '{
      "type": "FeatureCollection", 
      "features": [
    ';
    $friends = $this->Friends_model->get_friends($userid);
    foreach ($friends as $friend)
    {
      echo '
        {
          "type": "Feature",
          "id": "'.$friend->id.'",
          "properties": {
            "name": "'.$friend->name.'",
            "picture": "'.$friend->picture.'",
            "id": "'.$friend->id.'"
          },
          "geometry": {
            "type": "Point",
            "coordinates": ['.$friend->lon.', '.$friend->lat.']
          }
        },
      ';
    }
	$user = $this->Map_model->getUser($userid);
    echo '
      {
        "type": "Feature",
        "id": "'.$userid.'",
        "properties": {
          "name": "'.$user->name.'",
          "picture": "'.$user->picture.'"
        },
        "geometry": {
          "type": "Point",
          "coordinates": ['.$user->lon.', '.$user->lat.']
        }
      },
    ';
    echo "{}";
    echo ']}';
  }
  
  /**
   * Liefert alle Events inkl Positionen an denen der eingelogte Benutzer teilnimmt im GeoJSON Format zur Anzeige in der Kartenansicht
   */
  public function getevents()
  {
    $userid = $this->session->userdata("userid");
    $events = $this->Event_model->getEventsForUser($userid);
    
    echo '{
      "type": "FeatureCollection", 
      "features": [
    ';
    foreach ($events as $event)
    {
      $location = $this->location_model->getLocation($event->location);
      if (!is_array($location))
      {
      echo '
        {
          "type": "Feature",
          "id": "'.$event->id.'",
          "properties": {
            "title": "'.$event->title.'",
            "eventid": "'.$event->id.'"
          },
          "geometry": {
            "type": "Point",
            "coordinates": ['.$location->lon.', '.$location->lat.']
          }
        },
      ';
      }
    }
    echo "{}";
    echo ']}';
  }

}
?>