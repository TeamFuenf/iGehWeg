<?php

class Timeline_model extends CI_Model
{
    
  function __construct()
  {
    parent::__construct();
    $this->load->model("event/Event_model");  
  }
  
// --------------------------------------------------------------------------------------------------------------------

  public function createlink()
  {
    return anchor("event/new", "+");
  }
    

  public function getEvents($userid)
  {
    $events = $this->Event_model->getEvents($userid);    
    
    $buffer  = "";
    $buffer .= "<ul id='events'>";
    foreach($events as $event)
    {
      $button = "<button type='button' class='grey title'>".$event["title"]."</button>";
      $editbutton = "<button type='button' class='darkgrey edit'>edit</button>";
      $viewlink = anchor("event/".$event["id"], $button);   
      $editlink = anchor("event/edit/".$event["id"], $editbutton);
      $buffer .= "<li>".$viewlink . nbs(5) . $editlink."</li>";
    }
    $buffer .= "</ul>";
    return $buffer;
  }

// --------------------------------------------------------------------------------------------------------------------

}
