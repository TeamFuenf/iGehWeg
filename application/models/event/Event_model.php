<?php

class Event_model extends CI_Model
{
    
  function __construct()
  {
    parent::__construct();
    $this->load->helper("form");
    $this->load->model("friends/Friends_model");
  }
  
  /**
   * Belegungen der Dropdown Felder
   */
  private $hours = array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23");
  private $minutes = array("00","05","10","15","20","25","30","35","40","45","50","55");
  private $days = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
  private $months = array("01","02","03","04","05","06","07","08","09","10","11","12");
  private $years = array("2011", "2012", "2013");
    
// --------------------------------------------------------------------------------------------------------------------
  
  /**
   * Formular zum eintragen der Basisdaten eines Events
   * 
   * in:  falls eine eventid übergeben wird, wird dieses event verwendet um die Felder zum editieren auszufüllen
   *      wird keine id übergeben wird das Formular mit leeren String vorbelegt
   * 
   * out: Das (fertig ausgefüllte) Formular
   */
  public function getBasedataForm($eventid)
  {
    //TODO date("Y") auf Array mappen
    
    if ($eventid == null)
    {
      $event["id"] = uniqid("event", true);
      $event["location"] = "";  
      $event["title"] = "";
      $event["from"] = time();
      $event["to"] = time()+3600;      
    } 
    else
    {
      $event = $this->getEvent($eventid);          
    }
    
    $from["day"] = date("j", $event["from"])-1;
    $from["month"] = date("n", $event["from"])-1;
    $from["year"] = date("Y", $event["from"]);
    $from["hour"] = date("H", $event["from"]);
    $from["minute"] = round(date("i", $event["from"])/5);

    $to["day"] = date("j", $event["to"])-1;
    $to["month"] = date("n", $event["to"])-1;
    $to["year"] = date("Y", $event["to"])-1;
    $to["hour"] = date("H", $event["to"]);
    $to["minute"] = round(date("n", $event["to"])/5);
    
    $nextButton["name"] = "basedata_next";
    $nextButton["content"] = "weiter";
    
    $buffer  = "";  
    $buffer .= form_hidden("eventid", $event["id"]);  
    $buffer .= form_label("Location", "location");
    $buffer .= form_input("location", $event["location"]);
    $buffer .= br();
    $buffer .= form_label("Titel", "title");
    $buffer .= form_input("title", $event["title"]);
    $buffer .= br();
    $buffer .= form_label("Beginn", "from_day");
    $buffer .= form_dropdown("from_day", $this->days, $from["day"]);
    $buffer .= form_dropdown("from_month", $this->months, $from["month"]);
    $buffer .= form_dropdown("from_year", $this->years, $from["year"]);
    $buffer .= form_dropdown("from_hour", $this->hours, $from["hour"]);
    $buffer .= form_dropdown("from_minute", $this->minutes, $from["minute"]);
    $buffer .= br();
    $buffer .= form_label("Ende", "to");
    $buffer .= form_dropdown("to_day", $this->days, $to["day"]);
    $buffer .= form_dropdown("to_month", $this->months, $to["month"]);
    $buffer .= form_dropdown("to_year", $this->years, $to["year"]);
    $buffer .= form_dropdown("to_hour", $this->hours, $to["hour"]);
    $buffer .= form_dropdown("to_minute", $this->minutes, $to["minute"]);
    $buffer .= br();
    $buffer .= form_button($nextButton);

    return $buffer;
  }

  /**
   * Formular zum auswählen der Teilnehmer eines Events
   * 
   * in:  eine eventid; Die Daten des Events werden zur Vorbelegung genutzt
   * 
   * out: Eine Liste von Freunden (=Teilnehmer) des Eventerstellers
   */
  public function getMemberForm($eventid)
  {
    $this->db->where("eventid", $eventid);
    $query = $this->db->get("event_member");
    $members = $query->result();    
    $userid = $this->session->userdata("userid");
    $friends = $this->Friends_model->get_friends($userid);

    $nextButton["name"] = "members_next";
    $nextButton["content"] = "weiter";
    $prevButton["name"] = "members_prev";
    $prevButton["content"] = "zur&uuml;ck";
            
    $buffer  = "";
    $buffer .= "<table cellspacing='0' cellpadding='0'>";

    if (count($friends) == 0)
    {
      return;
    }
    
    foreach ($friends as $friend)
    {
      $status = "none";
      foreach ($members as $member)
      {
        if ($member->memberid == $friend->id)
        {
          $status = $member->status;
          break;
        }
      }
      $buffer .= "<tr class='member'>";
      $buffer .= "<td width='64'><img src='".$friend->picture."' width=64 height=64/></td>";
      $buffer .= "<td>".$friend->name."</td>";
      if ($status == "invited")
      {
        $buffer .= "<td width='200'><button style='width:100%' class='button invite' status='invited' id='".$friend->id."'>Einladung gesendet</button></td>";        
      }
      else if ($status == "attending")
      {
        $buffer .= "<td width='200'><button style='width:100%' class='button green invite' status='attending' id='".$friend->id."'>Nimmt teil</button></td>";        
      }
      else
      {
        $buffer .= "<td width='200'><button style='width:100%' class='button invite' id='".$friend->id."'>Einladen</button></td>";
      }
      $buffer .= "</tr>";
      $buffer .= "<tr><td colspan='3'>&nbsp;</td></tr>";
      
//      $buffer .= "<li id=\"".$friend->id."\">".$friend->name."(".$status.")</li>";      
      
    }
    $buffer .= "</table>";
    $buffer .= form_button($prevButton);
    $buffer .= form_button($nextButton);

    return $buffer;
  }

  /**
   * Formular zum abschicken eines Kommentars zu einem Event
   * 
   * in:  -
   * 
   * out: Ein Formular für das Erstellen eines Kommentars zu einem Event
   */
  public function getCommentForm()
  {
    $postCommentButton["name"] = "post_comment";
    $postCommentButton["content"] = "Kommentar senden";

    $textarea["name"] = "comment";
    $textarea["rows"] = "5";
    $textarea["cols"] = "40";
    
    $buffer  = "";
    $buffer .= form_label("Kommentar", "comment");
    $buffer .= br();
    $buffer .= form_textarea($textarea);
    $buffer .= br();
    $buffer .= form_button($postCommentButton);
    return $buffer;
  }

  public function getButton($name, $caption)
  {
    $button["name"] = $name;
    $button["content"] = $caption;  
    return form_button($button);
  }

// --------------------------------------------------------------------------------------------------------------------

  /**
   * liefert formatierte Basisdaten eines Events
   * 
   * in:  die ID des Events
   * 
   * out: formatiertes HTML
   */
  public function getBasedata($eventid)
  {
    $this->db->where("id", $eventid);
    $query = $this->db->get("event");
    $event = $query->row();
    $creator = $this->Friends_model->get_user($event->creator);
    
    $basedata->title = $event->title;
    $basedata->location = $event->location;
    $basedata->from = date("H:i, d.m.Y", $event->from);
    $basedata->to = date("H:i, d.m.Y", $event->to);
    $basedata->title = $event->title;
    $basedata->creator = $creator->name;
    $basedata->creatorpicture = $creator->picture;

    return $basedata;      
  }

  /**
   * liefert formatierte Teilnehmerdaten eines Events
   * 
   * in:  die ID des Events
   * 
   * out: formatiertes HTML
   */  
  public function getMembers($eventid)
  {
    $this->db->where("eventid", $eventid);
    $query = $this->db->get("event_member");
    
    $buffer  = "";
    $buffer .= "<ul>";
    foreach ($query->result() as $row)
    {
      $member = $this->Friends_model->get_user($row->memberid);
      $buffer .= "<li class='userprofile'><img src='".$member->picture."'/>".$member->name."</li>";
    } 
    $buffer .= "</ul>";
    return $buffer;      
  }

  /**
   * liefert formatierte Kommentare zu einem Event
   * 
   * in:  die ID des Events
   * 
   * out: formatiertes HTML
   */  
  public function getComments($eventid)
  {
    $this->db->where("eventid", $eventid);
    $this->db->order_by("time", "asc"); 
    $query = $this->db->get("event_comment");
    
    $buffer  = "";
    $buffer = "<ul id='comments'>";
    foreach ($query->result() as $row)
    {
      $author = $this->Friends_model->get_user($row->author);
      $buffer .= "<li>";
      $buffer .= "<table border='0'>";
      $buffer .= "<tr>";
      $buffer .= "<td rowspan='2'><img src='".$author->picture."' width='64' height='64'/></td>";
      $buffer .= "<td><b>".$author->name."</b></td>";
      $buffer .= "</tr>";      
      $buffer .= "<tr>";
      $buffer .= "<td>".nl2br($row->comment)."</td>";
      $buffer .= "</tr>";      
      $buffer .= "</table>"; 
      $buffer .= "</li>";
      
      //$buffer .= "<li><span class='event_comment_author'>".$author->name."</span><br><span class='event_comment_body'>".$row->comment."</span></li>";
    }  
    $buffer .= "</ul>";
    return $buffer;
  }

// ----------------------------------------------------------------------------

    /**
     * Liefert alle Events eines Users zurück
     * 
     * in:  Die ID des Users
     * 
     * out: die Events des Users als Array
     */
    public function getEvents($userid)
    {     
      $this->db->where("creator", $userid);
      $this->db->order_by("from", "desc"); 
      $query = $this->db->get("event");
      return $query->result_array();
    }

    /**
     * Liefert ein bestimmtes Event zurück
     * 
     * in:  Die ID des Events
     * 
     * out: Das Event als Array
     */
    public function getEvent($eventid)
    {
      $this->db->where("id", $eventid);
      $query = $this->db->get("event");
      
      if ($query->num_rows() > 0)
      {
        return $query->row_array();
      }
      else
      {
        return null;    
      }
    }
    
// ----------------------------------------------------------------------------
    
    /**
     * Setzt Basisdaten eines Events
     * 
     * in:  Das zu schreibende Tupel
     * 
     * out: -
     */
    public function updateBasedata($data)
    {
      // 1) Daten löschen
      $this->db->where("id", $data["id"]);
      $this->db->delete("event");  
            
      // 2) neue Daten eintragen
      $this->db->insert("event", $data);
    }

    /**
     * Setzt Teilnehmerdaten eines Events
     * 
     * in:  das zu schreibende Tupel
     * 
     * out: -
     */
    public function updateMembers($data)
    {
      // 1) Teilnehmer Tupel löschen
      $this->db->where("eventid", $data["eventid"]);
      $this->db->where("memberid", $data["memberid"]);
      $this->db->delete("event_member");  

      // 2) Teilnehmer und neuen Status eintragen
      $this->db->insert("event_member", $data);
    }

    /**
     * Setzt einen neuen Kommentar zu einem Event
     * 
     * in:  das zu schreibende Tupel
     * 
     * out: -
     */
    public function updateComment($data)
    {
      $this->db->insert("event_comment", $data);      
      echo $this->getComments($data["eventid"]);
    }

// ----------------------------------------------------------------------------

}
