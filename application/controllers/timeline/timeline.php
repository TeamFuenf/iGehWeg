<?php

class Timeline extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();
    $this->load->model("timeline/Timeline_forms");
    $this->load->model("timeline/Event_ajax");
    $this->load->model("timeline/Event");    

    // TODO global nach login
    $this->session->set_userdata("userid", "alex");
  }
       
  public function index()
  {
    $this->session->set_userdata("neweventid", uniqid("event", true));
    $userid = $this->session->userdata("userid");
    $data["events"] = $this->Event->getEvents($userid);
    $this->load->view("timeline/timeline", $data);
  }
  

// --- Neues Event erstellen --------------------------------------------------

  public function newevent()
  {
    $data["step1form"] = $this->Timeline_forms->location();
    $data["step2form"] = $this->Timeline_forms->friends();
    $data["step3form"] = $this->Timeline_forms->comment();
    $data["backlink"] = $this->Timeline_forms->backlink();
    $this->Event_ajax->newEventEntry($this->session->userdata("neweventid"));
    $this->load->view("timeline/newevent", $data);            
  }

// --- AJAX Funktionen -------------------------------------------------------

  public function updatelocation()
  {
    //TODO from_day, to_day
    $eventid = $this->session->userdata("neweventid");
    $data["title"] = $this->input->post("title", true);
    $data["location"] = $this->input->post("location", true);
    $data["from"] = mktime($this->input->post("from_hour", true), $this->input->post("from_minute", true));
    $data["to"] = mktime($this->input->post("to_hour", true), $this->input->post("to_minute", true));
    $data["creator"] = $this->session->userdata("userid");
    $this->Event_ajax->updateLocation($eventid, $data);
  }

  public function updateMembers()
  {
    $eventid = $this->session->userdata("neweventid");
    $members = $this->input->post("members", true);
    $this->Event_ajax->updateMembers($eventid, $members);
  }

// ----------------------------------------------------------------------------

}
?>