<?php

class Event_model extends CI_Model
{
    
  function __construct()
  {
    parent::__construct();
    $this->load->helper("form");
    $this->load->model("friends/Friends_model");
  }

// --------------------------------------------------------------------------------------------------------------------
  
  public function getEventLocations()
  {
    $this->db->order_by("name", "asc");
    $query = $this->db->get("location");
    return $query->result();
  }

  public function getEventMembers()
  {
    $userid = $this->session->userdata("userid");

    $this->db->where("id", $userid);
    $query = $this->db->get("friend");
    foreach ($query->result() as $row)
    {
      $list[] = $row->friendid;
    }
    
    $this->db->where_in("id", $list);
    $this->db->order_by("name", "asc");
    $query = $this->db->get("user");
    return $query->result();
  }

  public function getMemberStatus($eventid)
  {
    $this->db->where("eventid", $eventid);
    $query = $this->db->get("event_member");
    return $query->result();
  }
  
// --------------------------------------------------------------------------------------------------------------------

  public function getEvent($eventid)
  {
    $this->db->where("id", $eventid);
    $query = $this->db->get("event");
    return $query->row();
  }

  public function getOwnEvents()
  {
    $userid = $this->session->userdata("userid");
    $this->db->where("creator", $userid);
    $this->db->order_by("begintime", "asc");
    $query = $this->db->get("event");    
    return $query->result();
  }
  
  public function getParticipatingEvents()
  {
    $userid = $this->session->userdata("userid");
    
    $this->db->select("*");
    $this->db->from("event");
    $this->db->join("event_member", "event_member.eventid = event.id");
    $this->db->where("event_member.memberid", $userid);
    $query = $this->db->get();
    return $query->result();
  }
  
  public function getEventsForTimeline()
  {
    $userid = $this->session->userdata("userid");
$sql = "
SELECT *,
FROM_UNIXTIME(begintime, '%e') as 'day', 
FROM_UNIXTIME(begintime, '%c') as 'month', 
FROM_UNIXTIME(begintime, '%Y') as 'year',
FROM_UNIXTIME(begintime, '%H') as 'eventbegin',
FROM_UNIXTIME(begintime, '%i') as 'eventend',
FROM_UNIXTIME(begintime, '%H')*20+FROM_UNIXTIME(begintime, '%i') as 'offset1',
FROM_UNIXTIME(endtime, '%H')*20+FROM_UNIXTIME(endtime, '%i') as 'offset2'

FROM
(
SELECT *,
'creator' as 'status'
FROM event
WHERE creator = '".$userid."'

UNION

SELECT event.*,
'member' as 'status'
FROM event, event_member
WHERE event.id = event_member.eventid
AND event_member.memberid = '".$userid."'
) as events
ORDER BY begintime, endtime DESC
";
    
    $query = $this->db->query($sql);
    return $query->result();
  }

  public function getMembersForEvent($eventid)
  { 
    $userid = $this->session->userdata("userid");
    $sql = "
SELECT * 
FROM user
WHERE id IN
(
SELECT memberid
FROM event_member
WHERE eventid = '".$eventid."'

UNION

SELECT '".$userid."'
)
";
    $query = $this->db->query($sql);
    return $query->result();
  }
  
// --------------------------------------------------------------------------------------------------------------------

  public function setLocation($eventid, $locationid)
  {
    $event = $this->getEvent($eventid);
    if (empty($event))
    {
      // Neues Event anlegen
      $user = $this->session->userdata("userid");
      $event["id"] = $eventid;
      $event["creator"] = $user;
      $event["location"] = $locationid;
      $this->db->insert("event", $event);
    } 
    else
    {
      $event->location = $locationid;
      $this->db->where("id", $eventid);
      $this->db->update("event", $event);      
    }
  }
  
  public function setStatus($eventid, $memberid, $status)
  {
    $this->db->where("eventid", $eventid);
    $this->db->where("memberid", $memberid);
    $this->db->delete("event_member");
    
    if ($status != "none")
    {
      $data["eventid"] = $eventid;
      $data["memberid"] = $memberid;
      $data["status"] = $status;
      $this->db->insert("event_member", $data);      
    } 
  }

  public function setBasedata($eventid, $title, $from, $to)
  {
    $event = $this->getEvent($eventid);
    if (empty($event))
    {
      // Neues Event anlegen
      $user = $this->session->userdata("userid");
      $event["id"] = $eventid;
      $event["creator"] = $user;
      $event["title"] = $title;
      $event["begintime"] = $from;
      $event["endtime"] = $to;
      $this->db->insert("event", $event);
    } 
    else
    {
      $event->title = $title;
      $event->begintime = $from;
      $event->endtime = $to;
      $this->db->where("id", $eventid);
      $this->db->update("event", $event);      
    }
  }

// --------------------------------------------------------------------------------------------------------------------

  public function cleanup()
  {
    $userid = $this->session->userdata("userid");
    
    // Leere Events suchen
    $this->db->where("creator", $userid);
    $this->db->where("title", "");
    $query = $this->db->get("event");
    
    // Leere Events löschen
    $this->db->where("creator", $userid);
    $this->db->where("title", "");
    $this->db->delete("event");
    
    // Teilnehmer von leeren Events löschen
    foreach($query->result() as $row)
    {
      $this->db->where("eventid", $row->id);
      $this->db->delete("event_member");  
    }
  }
    
// --------------------------------------------------------------------------------------------------------------------
}
  
?>