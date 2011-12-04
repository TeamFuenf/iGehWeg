<?php

class Event extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();
    $this->load->model("event/Event_model");    

    // TODO global nach login
    $this->session->set_userdata("userid", "alex");
  }
  
// --------------------------------------------------------------------------------------------------------------------

  public function index()
  {
    $eventid = $this->uri->segment(2);
    $event = $this->Event_model->getEvent($eventid);
  
    $data["title"] = $event["title"];

    $data["basedata"] = $this->Event_model->getBasedata($eventid);
    $data["members"] = $this->Event_model->getMembers($eventid);
    $data["comments"] = $this->Event_model->getComments($eventid);
    
    $data["commentForm"] = $this->Event_model->getCommentForm(null);

    $this->layout->view("event/showevent", $data);
  }  

// --------------------------------------------------------------------------------------------------------------------

  public function newevent()
  {
    $data["title"] = "Neues Event erstellen";
    
    $data["basedataForm"] = $this->Event_model->getBasedataForm(null);
    $data["memberForm"] = $this->Event_model->getMemberForm(null);
    $data["commentForm"] = $this->Event_model->getCommentForm(null);
    
    $data["comments"] = $this->Event_model->getComments(null);
    
    $this->layout->view("event/event", $data);
  }
  
  public function editevent()
  {
    $eventid = $this->uri->segment(3);

    $data["title"] = "Event bearbeiten";
    $data["basedataForm"] = $this->Event_model->getBasedataForm($eventid);
    $data["memberForm"] = $this->Event_model->getMemberForm($eventid);
    $data["commentForm"] = $this->Event_model->getCommentForm($eventid);
    
    $data["comments"] = $this->Event_model->getComments($eventid);

    $this->layout->view("event/event", $data);
  }  
  
// --------------------------------------------------------------------------------------------------------------------

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
    $eventid = $this->input->post("eventid");
    $members = $this->input->post("members", true);
    $this->Event_model->updateMembers($eventid, $members);
  }

  public function updateComment()
  {
    $data["eventid"] = $this->input->post("eventid");
    $data["author"] = $this->session->userdata("userid");    
    $data["comment"] = $this->input->post("comment");
    $data["time"] = time();
    $this->Event_model->updateComment($data);    
  }
  
}
?>