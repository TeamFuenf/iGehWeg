<?php

class Event extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();
    parent::is_logged_in();
    $this->load->model("event/Event_model");
    $this->load->model("friends/Friends_model");
    $this->Event_model->cleanup();
  }
  
// --------------------------------------------------------------------------------------------------------------------

  public function ical()
  {
    header("Content-Type: text/Calendar");
    header("Content-Disposition: inline; filename=calendar.ics");      
    $eventid = $this->uri->segment(3);
    echo $this->Event_model->generateICal($eventid);  
  }
  
// --------------------------------------------------------------------------------------------------------------------

  public function newevent()
  {
    $event->new = true;
    $event->title = "";
    $event->begintime = time();
    $event->endtime = time();
    $event->location = 0;
    
    // Prüfen ob ein Datum in der URL übergeben wurde
    if ($this->uri->segment(3))
    {
      $ts = $this->uri->segment(3);
      $preselectedTime = mktime(date("H"), floor(date("i")/5)*5, 0, date("n",$ts), date("j",$ts), date("Y",$ts));
      $event->begintime = $preselectedTime;
      $preselectedTime = mktime(date("H")+1, floor(date("i")/5)*5, 0, date("n",$ts), date("j",$ts), date("Y",$ts));
      $event->endtime = $preselectedTime;
    }
    
    $data["eventid"] = uniqid("event", true);
    $data["title"] = "Neues Event erstellen";
    $data["locations"] = $this->Event_model->getPossibleLocations();
    $data["members"] = $this->Event_model->getPossibleMembers();
    $data["event"] = $event;
        
    $this->layout->view("event/event", $data);
  }

  public function editevent()
  {
    $eventid = $this->uri->segment(3);

    $data["eventid"] = $eventid;
    $data["locations"] = $this->Event_model->getPossibleLocations();
    $data["members"] = $this->Event_model->getAllEventMembers($eventid);
    $data["event"] = $this->Event_model->getEvent($eventid);

    $this->layout->view("event/event", $data);
  }  

  public function showevent()
  {
    $userid = $this->session->userdata("userid");
    $eventid = $this->uri->segment(2);    
    $event = $this->Event_model->getEvent($eventid);
    $data["user"] = $this->Friends_model->get_user($userid);
    $data["creator"] = $this->Friends_model->get_user($event->creator);
    $data["event"] = $event;
    $data["members"] = $this->Event_model->getEventMembers($eventid);
    $data["location"] = "TODO: Locationdetails...";
    $data["comments"] = $this->Event_model->getComments($eventid);
    $this->layout->view("event/showevent", $data);
  }
  
  public function deleteevent()
  {
    $eventid = $this->uri->segment(3);    
    if ($this->Event_model->deleteEvent($eventid))
    {
      redirect("timeline");      
    }
    else
    {
      // TODO: Fehlermeldung: Löschen nicht erlaubt ?
    }
  }
  
// --------------------------------------------------------------------------------------------------------------------

  public function insertComment()
  {
    $eventid = $this->input->post("eventid", true);
    $comment = $this->input->post("comment", true);

    $this->Event_model->insertComment($eventid, $comment);
  }
  
// --------------------------------------------------------------------------------------------------------------------

  public function updateLocation()
  {
    $eventid = $this->input->post("eventid", true);
    $locationid = $this->input->post("locationid", true);    
    $this->Event_model->setLocation($eventid, $locationid);
    echo "okay";
  }
  
  public function updateMember()
  {
    $eventid = $this->input->post("eventid", true);
    $memberid = $this->input->post("memberid", true);    
    $status = $this->input->post("status", true);    
    $this->Event_model->setStatus($eventid, $memberid, $status);
    echo "okay";  
  }
  
  public function updateBasedata()
  {
    $eventid = $this->input->post("eventid", true);
    $title = $this->input->post("title", true);
    
    $from_hour = $this->input->post("from_hour", true);
    $from_minute = $this->input->post("from_minute", true);
    $from_day = $this->input->post("from_day", true);
    $from_month = $this->input->post("from_month", true);
    $from_year = $this->input->post("from_year", true);
    $to_hour = $this->input->post("to_hour", true);
    $to_minute = $this->input->post("to_minute", true);
    $to_day = $this->input->post("to_day", true);
    $to_month = $this->input->post("to_month", true);
    $to_year = $this->input->post("to_year", true);
    
    $from = mktime($from_hour, $from_minute, 0, $from_month, $from_day, $from_year);
    $to = mktime($to_hour, $to_minute, 0, $to_month, $to_day, $to_year);
  
    $this->Event_model->setBasedata($eventid, $title, $from, $to);
    
    echo "okay";
  }
}
?>