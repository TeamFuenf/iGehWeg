<?php
class Location extends CI_Controller {
	
  public function __construct()
  {
    parent::__construct();
    parent::is_logged_in();
    $this->load->model("location/Location_model");
  }

// --------------------------------------------------------------------------------------------------------------------

  // Normale Kartenansicht
  function index()
  {    
	$this->layout->view("map/map", $data);
  }

  public function add()
  {
    $name = $this->input->post("name", true);
    $lon = $this->input->post("lon", true);
    $lat = $this->input->post("lat", true);
    $adress = $this->input->post("adress", true);
    $city = $this->input->post("city", true);
    $this->Location_model->addLocation($name, $lon, $lat, $adress, $city);
    redirect('/map', 'refresh');
  }
  
  public function getnewlocation($lon, $lat)
  {
    echo '{
      "type": "FeatureCollection", 
      "features": [
        {
          "type": "Feature",
          "id": "0815",
          "properties": {
            "name": "Neue Location"
          },
          "geometry": {
            "type": "Point",
            "coordinates": ['.$lon.', '.$lat.']
          }
        },
      {}
    ]}';
  }
  
  
  
  public function getnewlocationform()
  {
    $this->load->helper('form');
    
    echo form_open('/base/login_control/validate_credentials');
    echo form_input('newlocname', '', 'placeholder="Name"');
    echo form_input('newlocaddress', '', 'placeholder="Adresse"');
    echo form_input('newloccity', '', 'placeholder="Stadt"');
    $js = 'onClick="some_function()"';
    echo form_button('submit', 'Fertig', $js);    
    echo form_close();
    
// Would produce:

// <input type="text" name="username" id="username" value="johndoe" maxlength="100" size="50" style="width:50%" />
    
  }
  
  public function geteditlocationform($locid)
  {
    // model aufrufen und daten aus db lesen,

    $query = $this->db->get_where('location', array('id' => $locid));
    
    
    //hier daten eintragen
    $locname = "name";
    $loctype = "type";
    $locstreet = "street";
    $loccity = "city";
    $locinternet = "www.internet.de";
    $locemail = "e@mail.com";
    
    echo form_open('/uri/fehlt/noch');
    echo form_input('locname', $locname);
    echo form_input('locstreet', $locstreet);
    echo form_input('loccity', $loccity);
    echo form_input('locinternet', $locinternet);
    echo form_input('locemail', $locemail);
    $js1 = 'onClick="some_function()"';
    echo form_button('submit', 'Fertig', $js1);
    $js2 = 'onClick="some_function()"';
    echo form_button('delete', 'Löschen', $js2);
    echo form_close();
    
  }
  
  public function saveeditlocation($locid, $locattr, $locvalue)
  {
    // ans model übergeben und in die datenbank speichern.
    $data = array(
               $locattr => $locvalue
            );
    $this->db->where('id', $locid);
    $this->db->update('location', $data);
    // javascript funktion muss die view selbstständig aktuallisieren, also ohne weiteren datenbankaufruf
  }
  
  function deletelocation($locid)
  {
    $this->Location_model->deleteLocation($locid);
  }

}
?>