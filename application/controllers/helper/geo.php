<?php

class Geo extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();
    $this->load->model("map/Map_model");
  }

  public function update()
  {
    $userid = $this->session->userdata("userid");
    $lon = $this->uri->segment(4);
    $lat = $this->uri->segment(5);
    $this->Map_model->updateUserGeo($userid, $lon, $lat);
    echo "okay";
  }

}
?>