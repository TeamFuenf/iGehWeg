<?php

class Timeline extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();
    parent::is_logged_in();  
    $this->load->model("event/Event_model");    
    $this->load->model("friends/Friends_model");    
  }

  public function event()
  {
    $userid = $this->session->userdata("userid");
    $data["createlink"] = anchor("event/new", "+");
    $data["userid"] = $userid;
    $data["ownevents"] = $this->Event_model->getOwnEvents();
    $data["participatingeventsts"] = $this->Event_model->getParticipatingEvents();
  
    $data["events"] = $this->Event_model->getEventsForTimeline();

    $this->layout->view("timeline/events", $data);
  }
  
  public function index()
  {
    $events = $this->Event_model->getEventsForTimeline();
    $userid = $this->session->userdata("userid");
    
    $eventmembers = array();
    $eventcreators = array();
    foreach ($events as $e)
    {
      $creator = $this->Friends_model->get_user($e->creator);
      $eventcreators[$e->id] = $creator;
      
      $members = $this->Event_model->getEventMembers($e->id);
      $eventmembers[$e->id] = $members;
    } 
   
    $data["userid"] = $userid;
    $data["events"] = $events;
    $data["eventmembers"] = $eventmembers;
    $data["eventcreators"] = $eventcreators;    
    $this->layout->view("timeline/timeline", $data);  
  }
  
}
?>