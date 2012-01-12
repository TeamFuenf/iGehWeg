<?php

class External extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();
    $this->load->model("event/Event_model");
  }

// --------------------------------------------------------------------------------------------------------------------

  public function ical()
  {
    header("Content-Type: text/Calendar");
    header("Content-Disposition: inline; filename=calendar.ics");      
    $eventid = $this->uri->segment(3);
    echo $this->Event_model->generateICal($eventid);  
  }

}
?>