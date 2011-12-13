<?php

class Event extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();
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
    
/*
    $data["basedataUrl"] = base_url("event/update/basedata");
    $data["memberUrl"] = base_url("event/update/member");
    $data["commentUrl"] = base_url("event/update/comment");
    
    $data["basedataForm"] = $this->Event_model->getBasedataForm($eventid);
    $data["memberForm"] = $this->Event_model->getMemberForm($eventid);
    $data["commentForm"] = $this->Event_model->getCommentForm($eventid);
    
    $data["comments"] = $this->Event_model->getComments($eventid);
*/
    $this->layout->view("event/event", $data);
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
    $from_date = $this->input->post("from_date", true);
    $from_time = $this->input->post("from_time", true);
    $to_date = $this->input->post("to_date", true);
    $to_time = $this->input->post("to_time", true);
    
    $from = strtotime($from_date." ".$from_time);
    $to = strtotime($to_date." ".$to_time);
  
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