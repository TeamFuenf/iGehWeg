<?php

class Event extends CI_Controller
{
  
  public function __construct()
  {
    parent::__construct();
  }
       
  public function index()
  {
    echo "event";
  }
  
// --- AJAX Funktionen -------------------------------------------------------

  
  public function comment()
  {
    $action = $this->uri->segment(4);

//    $eventid = $this->input->get("eventid" ,TRUE);
//    $memberid = $this->input->get("memberid" ,TRUE);
//    $this->Timeline_event->removeMember($eventid, $memberid);

    switch ($action)
    {
      case "add":
        echo "Kommentar hinzufügen";
        break;
      case "edit":
        echo "Kommentar bearbeiten";
        break;
      case "remove":
        echo "Kommentar löschen";
        break;
    }
  }

}

?>