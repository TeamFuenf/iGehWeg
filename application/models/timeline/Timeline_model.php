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
    
  public function getOwnEvents($userid)
  {
    $events = $this->Event_model->getOwnEvents($userid);    
    
    $buffer  = "";
    if (count($events) > 0)
    {      
      $buffer .= "<ul id='ownevents'>";
      foreach($events as $event)
      {
        $button = "<button type='button' class='grey title'>".$event["title"]."</button>";
        $editbutton = "<button type='button' class='darkgrey edit'>bearbeiten</button>";
//        $viewlink = anchor("event/".$event["id"], $button);   
        $viewlink = anchor("event/show/".$event["id"], $event["title"]);   
        $editlink = anchor("event/edit/".$event["id"], $editbutton);
        $buffer .= "<li>".$viewlink . nbs(5) . $editlink."</li>";
      }
      $buffer .= "</ul>";
    }
    else
    {
      $buffer .= "Du hast momentan keine eigenen Veranstaltungen";      
    }
    return $buffer;
  }

  public function getForeignEvents($userid)
  {
    $events = $this->Event_model->getForeignEvents($userid);    
    $buffer  = "";
    if (count($events) < 1)
    {
      return "Du hast momentan keine ausstehenden Veranstaltungen.";  
      break;
    }
    
    $buffer .= "<ul id='foreignevents'>";
    $buffer .= "</ul>";

/*    
    if (count($events) > 0)
    {
      $buffer .= "<ul id='foreignevents'>";
      foreach($events as $event)
      {
        $userid = $this->session->userdata("userid");
        $status = $this->Event_model->getMemberStatus($event["id"], $userid);
        $viewlink = anchor("event/".$event["id"], $button);   
        
        $buffer .= "<li>";
        $buffer .= $viewlink.nbs(5);

        if ($status == "attending")
        {
          $caption = "absagen";
        }
        else
        {
          
        }
        else if ($status == "attending")
        {
          $caption = "teilnehmen";
        }

        $buffer .= "</li>";
        
        $actionbutton = "<button type='button' eventid='".$event["id"]."' memberid='".$userid."' status='".$status."' class='darkgrey action'>".$caption."</button>";                  
        $button = "<button type='button' class='grey title'>".$event["title"]."</button>";
//        $actionlink = anchor("event/edit/".$event["id"], $actionbutton);
      }      
      $buffer .= "</ul>";
    }
    else
    {
      $buffer .= "Du hast momentan keine ausstehenden Veranstaltungen.";  
    }
 */
    return $buffer;
  }
// --------------------------------------------------------------------------------------------------------------------

}
