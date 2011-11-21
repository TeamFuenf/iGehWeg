<?php

class Event_ajax extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    public function newEventEntry($eventid)
    {
      $this->db->where("id", $eventid);
      $numRows = $this->db->count_all_results("event");
      if ($numRows < 1)
      {
        $newEventData["id"] = $eventid;
        $this->db->insert("event", $newEventData);
      }    
    }

// ----------------------------------------------------------------------------
   
    public function updateLocation($eventid, $data)
    {
      $this->db->where("id", $eventid);
      $this->db->update("event", $data);
    }

    public function updateMembers($eventid, $members)
    {
      // 1) Alle Teilnehmer löschen
      $this->db->where("eventid", $eventid);
      $this->db->delete("event_member");  

      // 2) neue Teilnehmer eintragen
      foreach($members as $member)
      {
        $data["eventid"] = $eventid;
        $data["memberid"] = $member;
        $this->db->insert("event_member", $data);
      }
    }

// ----------------------------------------------------------------------------

  public function finishEvent()
  {
    $this->session->unset_userdata("neweventid");
  }
  
}
