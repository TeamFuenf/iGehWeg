<?php

class Images extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();
    $this->load->model("helper/Userimage");    
  }

  public function user()
  {
    $type = $this->uri->segment(4);
    $userid = $this->uri->segment(5);
    $image = "";
    
    if ($type == "plain")
    {
      $image = $this->Userimage->plain($userid);
    }
    if ($type == "marker")
    {
      $image = $this->Userimage->marker($userid);
    }
    if ($type == "timeline")
    {
      $image = $this->Userimage->timeline($userid);
    }

    echo $image;
  }

// ----------------------------------------------------------------------------

}
?>