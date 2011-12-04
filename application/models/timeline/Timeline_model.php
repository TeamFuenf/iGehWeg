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
    $buffer .= "<ul>";
    foreach($events as $event)
    {
      $viewlink = anchor("event/".$event->id, $event->title);   
      $editlink = anchor("event/edit/".$event->id, "edit");
      $buffer .= "<li>".$viewlink . nbs(5) . $editlink."</li>";
    }
    $buffer .= "</ul>";
    return $buffer;
  }
  
// --------------------------------------------------------------------------------------------------------------------

}
