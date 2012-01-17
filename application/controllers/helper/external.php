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
    header("Content-Disposition: inline; filename=event.ics");      
    $eventid = $this->uri->segment(3);
    echo $this->Event_model->generateICal($eventid);  
  }

  public function showevent()
  {
    $userid = "external";
    $eventid = $this->uri->segment(3);    
    $event = $this->Event_model->getEvent($eventid);
    $data["event"] = $event;
    $data["creator"] = $this->Friends_model->get_user($event->creator);
    $data["members"] = $this->Event_model->getEventMembers($eventid);
    $data["location"] = "TODO: location";
    $data["comments"] = $this->Event_model->getComments($eventid);
    $this->layout->viewexternal("event/showeventexternal", $data, false);
  }
  
}
?>