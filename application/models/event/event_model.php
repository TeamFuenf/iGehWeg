<?php

class Event_model extends CI_Model
{
    
  function __construct()
  {
    parent::__construct();
    $this->load->helper("form");
    $this->load->model("friends/Friends_model");
    $this->load->model("messaging/Messaging_model");
    $this->load->model("map/Map_model");
  }

// --------------------------------------------------------------------------------------------------------------------

  /**
   * Liefert alle möglichen Orte für ein Event, wenn möglich nach Entfernung zum User sortiert
   */
  public function getPossibleLocations()
  {
    $userid = $this->session->userdata("userid");
    
    // Abstandsberechnung mittels Phytagoras ausreichend genau da nur relativ kleine Distanzen
    // 71.5 km = Abstand zwischen zwei Längengraden in Mitteleuropa
    // 111.3 km = Abstand zwischen zwei Breitengraden in Mitteleuropa
    $sql = "
    SELECT location.*, 
    ROUND(SQRT(POW(71.5 * (location.lon - user.lon),2) + POW(111.3 * (location.lat - user.lat),2)) * 1000) as distance
    FROM user, location
    WHERE user.id = '".$userid."'
    ORDER BY distance";
    $query = $this->db->query($sql);
    return $query->result();    
  }  
  
  /**
   * Liefert alle möglichen Teilnehmer für ein Event = die Freundesliste eines Benutzers
   * TODO: Von FriendModel holen
   */
  public function getPossibleMembers()
  {
    $userid = $this->session->userdata("userid");
    $sql = "
    SELECT *, 'null' as status
    FROM friend, user
    WHERE friend.friendid = user.id
    AND friend.id = '".$userid."'
    ORDER BY user.name ASC
    ";
    $query = $this->db->query($sql);
    return $query->result();  
  }

  /**
   * liefert alle Teilnehmer (zugesagt und noch mögliche Freunde) für ein Event
   */
  public function getAllEventMembers($eventid)
  {
    $userid = $this->session->userdata("userid");
    $sql = "
    SELECT user.*, 'null' as status
    FROM friend, user
    WHERE friend.id = '".$userid."'
    AND user.id = friend.friendid
    AND friendid NOT IN
    (
        SELECT memberid
        FROM event_member
        WHERE eventid = '".$eventid."'
    )
    
    UNION
    
    SELECT user.*, event_member.status
    FROM event_member, user
    WHERE event_member.memberid = user.id
    AND eventid = '".$eventid."'
    ORDER BY name ASC
    ";
        
    $query = $this->db->query($sql);    
    return $query->result();
  }
  
  /**
   * liefert alle Teilnehmer eines Events alphabetisch sortiert
   */
  public function getEventMembers($eventid)
  {    
    $this->db->select("*");
    $this->db->from("event_member");
    $this->db->join("user", "event_member.memberid = user.id");
    $this->db->where("event_member.eventid", $eventid);
    $this->db->order_by("user.name", "asc");
    $query = $this->db->get();    
    return $query->result();
  }

// --------------------------------------------------------------------------------------------------------------------

  public function deleteEvent($eventid)
  {
    $userid = $this->session->userdata("userid");
    $event = $this->getEvent($eventid);
    if ($userid == $event->creator)
    {
      $tables = array("event", "event_comment", "event_member");
      $this->db->where("id", $event->id);
      $this->db->delete("event"); 
      return true;
    }
    else
    {
      return false;
    }
  }
  

// --------------------------------------------------------------------------------------------------------------------

  public function getEvent($eventid)
  {
    $this->db->where("id", $eventid);
    $query = $this->db->get("event");
    return $query->row();
  }

  public function getEventsForUser($userid)
  {
    $sql = "
    SELECT *
    FROM event
    WHERE creator = '".$userid."'
    OR id IN 
    (
    SELECT eventid
    FROM event_member
    WHERE memberid = '".$userid."'
    )";
    $query = $this->db->query($sql);
    return $query->result();    
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
    
    if ($status == "invited")
    {
      $event = $this->getEvent($eventid);
      $msg = "<b>Automatische Nachricht:</b>\nDu wurdest zum Event \"".$event->title."\" eingeladen.";
      $this->Messaging_model->send($memberid, $msg);
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


  public function checkPlausibility($from, $to)
  {
    $userid = $this->session->userdata("userid");
    
    // Sind die Zeitpunkte in der richtigen Reihenfolge ?
    if ($to < $from)
    {
      return "Falsche Zeitreihenfolge";
    }
    
    // Liegt das Event in der Vergangenheit ?
    $now = time();
    if ($to < $now || $from < $now)
    {
      return "Event in der Vergangenheit";
    }
    
    // Schneiden die Zeiten ein anderes Event zu dem der User eingeladen ist ?
    $sql = "
    SELECT *
    FROM event
    WHERE creator = '".$userid."'
    OR id IN (
    SELECT eventid
    FROM event_member
    WHERE memberid = '".$userid."'
    )
    ";
    $query = $this->db->query($sql);
    $attendingevents = $query->result();
    
    foreach ($attendingevents as $event)
    {
      if (
        ($from <= $event->begintime && $to <= $event->endtime) || ($from >= $event->begintime && $to >= $event->endtime)
      )
      {
          // Keine überschneidung
      }
      else
      {
        return "Event überschneidet sich mit dem vorhandenem Event ".$event->title; 
      }
    }
    return "okay";
  }

  public function checkAttendance($from, $to)
  {
    $userid = $this->session->userdata("userid");
    
    // Schneiden die Zeiten ein anderes Event zu dem der User eingeladen ist ?
    $sql = "
    SELECT *
    FROM event
    WHERE creator = '".$userid."'
    OR id IN (
    SELECT eventid
    FROM event_member
    WHERE memberid = '".$userid."'
    AND status <> 'invited'
    )
    ";
    $query = $this->db->query($sql);
    $attendingevents = $query->result();
    
    foreach ($attendingevents as $event)
    {
      if (
        ($from <= $event->begintime && $to <= $event->endtime) || ($from >= $event->begintime && $to > $event->endtime)
      )
      {
          // Keine überschneidung
      }
      else
      {
        return "Event überschneidet sich mit dem vorhandenen Event ".$event->title; 
      }
    }
    return "okay";
  }

// --------------------------------------------------------------------------------------------------------------------

  public function insertComment($eventid, $comment)
  {
    $data["eventid"] = $eventid;
    $data["author"] = $this->session->userdata("userid");
    $data["comment"] = $comment;
    $data["time"] = time();
    $this->db->insert("event_comment", $data);     
  }
  
  public function getComments($eventid)
  {
    $sql = "
    SELECT event_comment.*, user.name, user.picture
    FROM event_comment, user 
    WHERE event_comment.eventid = '".$eventid."'
    AND event_comment.author = user.id
    ORDER BY event_comment.time ASC
    ";
    $query = $this->db->query($sql);    
    return $query->result();
  }

// --------------------------------------------------------------------------------------------------------------------

  public function generateICal($eventid)
  {
    $event = $this->getEvent($eventid);
    $eventmembers = $this->getEventMembers($eventid);
    $creator = $this->Friends_model->get_user($event->creator);
    $location = $this->Map_model->getLocation($event->location);
    
    echo "BEGIN:VCALENDAR\n";
    echo "VERSION:2.0\n";
    echo "PRODID:PHP\n";
    echo "METHOD:REQUEST\n";
    echo "BEGIN:VEVENT\n";
    echo "LOCATION:".$location->name."\n";
    echo "DTSTART:".date("Ymd", $event->begintime).'T'.date("His", $event->begintime)."\n";
    echo "DTEND:".date("Ymd", $event->endtime).'T'.date("His", $event->endtime)."\n";
    echo "CREATOR:".$event->creator."\n";
    echo "SUMMARY:".$event->title."\n";
    echo "DESCRIPTION:Event von ".$creator->name.". Mehr Infos unter: ".site_url("event/".$event->id)."\n";
    echo "UID:1\n";
    echo "SEQUENCE:0\n";
    echo "DTSTAMP:".date('Ymd').'T'.date('His')."\n";
    echo "ATTENDEE;CN=".$creator->name.";CUTYPE=INDIVIDUAL;PARTSTAT=ACCEPTED;RSVP=FALSE:invalid:nomail\n";                
    
    foreach ($eventmembers as $member)
    {
      if ($member->status == "attending")
      {
        echo "ATTENDEE;CN=".$member->name.";CUTYPE=INDIVIDUAL;PARTSTAT=ACCEPTED;RSVP=FALSE:invalid:nomail\n";                
      }
      else
      {
        echo "ATTENDEE;CN=".$member->name.";CUTYPE=INDIVIDUAL;PARTSTAT=NEEDS-ACTION;RSVP=FALSE:invalid:nomail\n";        
      }
    }

    echo "URL:".site_url("event/".$event->id)."\n";
    echo "END:VEVENT\n";
    echo "END:VCALENDAR\n"; 
 
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
