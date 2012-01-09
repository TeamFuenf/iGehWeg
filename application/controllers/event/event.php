<?php

class Event extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();
    parent::is_logged_in();
    $this->load->model("event/Event_model");
  }
  
// --------------------------------------------------------------------------------------------------------------------

  public function newevent()
  {
    $this->Event_model->cleanup();
    
    $event->title = "";
    $event->begintime = time();
    $event->endtime = time();
    $event->location = 0;
    
    if ($this->uri->segment(3))
    {
      // Neue Events automatisch von 10-11 Uhr gesetzt
      $ts = $this->uri->segment(3);
      $preselectedTime = mktime(10, 0, 0, date("n",$ts), date("j",$ts), date("Y",$ts));
      $event->begintime = $preselectedTime;
      $preselectedTime = mktime(11, 0, 0, date("n",$ts), date("j",$ts), date("Y",$ts));
      $event->endtime = $preselectedTime;
    }
    
    $data["eventid"] = uniqid("event", true);
    $data["title"] = "Neues Event erstellen";
    $data["locations"] = $this->Event_model->getEventLocations();
    $data["members"] = $this->Event_model->getEventMembers();
    $data["event"] = $event;
        
    $this->layout->view("event/event", $data);
  }

  public function editevent()
  {
    $this->Event_model->cleanup();
    $eventid = $this->uri->segment(3);
    $memberstats = $this->Event_model->getMemberStatus($eventid);
    if (!empty($memberstats))
    {
      foreach($memberstats as $stat)
      {
        $memberstatus[$stat->memberid] = $stat->status;  
      }
    }
    else
    {
      $memberstatus = array();
    }
    
    $data["eventid"] = $eventid;
    $data["title"] = "Event bearbeiten";
    $data["locations"] = $this->Event_model->getEventLocations();
    $data["members"] = $this->Event_model->getEventMembers();
    $data["memberstatus"] = $memberstatus;
    $data["event"] = $this->Event_model->getEvent($eventid);

      $this->layout->view("event/event", $data);
  }  

  public function showevent()
  {
    $eventid = $this->uri->segment(2);    
    $event = $this->Event_model->getEvent($eventid);
    $data["event"] = $event;
    $data["members"] = $this->Event_model->getAllEventMembers($eventid);
    $data["location"] = "TODO: Locationdetails...";
    
    $this->layout->view("event/showevent", $data);
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
  
/*
  public function updateBasedata()
  {
    $data["id"] = $this->input->post("eventid");
    $data["title"] = $this->input->post("title", true);
    $data["location"] = $this->input->post("location", true);
    
    $data["from"] = mktime(
      $this->input->post("from_hour", true), 
      $this->input->post("from_minute", true), 
      0, 
      $this->input->post("from_month", true), 
      $this->input->post("from_day", true), 
      $this->input->post("from_year", true)
    );
    
    $data["to"] = mktime(
      $this->input->post("to_hour", true), 
      $this->input->post("to_minute", true), 
      0, 
      $this->input->post("to_month", true), 
      $this->input->post("to_day", true), 
      $this->input->post("to_year", true)
    );

    $data["creator"] = $this->session->userdata("userid");
    $this->Event_model->updateBasedata($data);
    echo "okay";
  }

  public function updateMembers()
  {
    $data["eventid"] = $this->input->post("eventid");    
    $data["memberid"] = $this->input->post("memberid");    
    $data["status"] = $this->input->post("status");    
    $this->Event_model->updateMembers($data);
    echo "okay";
  }

  public function updateStatus()
  {
    $data["eventid"] = $this->uri->segment(4); 
    $data["memberid"] = $this->session->userdata("userid");   
    $data["status"] = $this->uri->segment(5);   
    $this->Event_model->updateMembers($data);
    echo "okay";
  }

  public function updateComment()
  {
    $data["eventid"] = $this->input->post("eventid");
    $data["author"] = $this->session->userdata("userid");    
    $data["comment"] = $this->input->post("comment");
    $data["time"] = time();
    $this->Event_model->updateComment($data);
  }
*/  
}
?>