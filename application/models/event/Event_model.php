<?php

class Event_model extends CI_Model
{
    
  function __construct()
  {
    parent::__construct();
    $this->load->helper("form");
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
    //TODO Vorbelegung einfügen
    $friends = $this->getFriendsArray();
    
    $nextButton["name"] = "members_next";
    $nextButton["content"] = "weiter";
    $prevButton["name"] = "members_prev";
    $prevButton["content"] = "zur&uuml;ck";
    
    $buffer  = "";
    $buffer .= "<ul>";
    $buffer .= $friends;
    $buffer .= "</ul>";
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
    $prevButton["name"] = "comments_prev";
    $prevButton["content"] = "zur&uuml;ck";

    $postCommentButton["name"] = "post_comment";
    $postCommentButton["content"] = "Kommentar senden";

    $buffer  = "";
    $buffer .= form_label("Kommentar", "comment");
    $buffer .= form_textarea("comment");
    $buffer .= form_button($postCommentButton);
    $buffer .= br();
    $buffer .= form_button($prevButton);
    return $buffer;
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
    
    $buffer  = "";
    $buffer .= "Titel: ".$event->title;
    $buffer .= br();
    $buffer .= "Location: ".$event->location;
    $buffer .= br();
    $buffer .= "Von: ". date("H:i, d.m.Y", $event->from);
    $buffer .= br();
    $buffer .= "Bis: ". date("H:i, d.m.Y", $event->to);
    $buffer .= br();
    $buffer .= "Erstellt von: ".$event->creator;
    
    return $buffer;      
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

    $members = array();
    foreach ($query->result() as $row)
    {
      $members[] = $row->memberid;
    } 
    $buffer .= ul($members);
    
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
    $buffer = "<ul>";
    foreach ($query->result() as $row)
      {
        $buffer .= "<li><span class='event_comment_author'><img src=\"autor\"></span><span class='event_comment_body'>".$row->comment."</span></li>";
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
     * in:  Die ID des Events
     *      Eine Liste mit den Teilnehmer IDs
     * 
     * out: -
     */
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


//--- 8< snip -----------
    //TODO das kommt später mal aus dem Friend Model -> Philipp
    public function getFriendsArray()
    {
      $friends;
      $friends["hannes"] = "Hannes Koeppel";
      $friends["philipp"] = "Philipp Fauser";
      $friends["alex"] = "Alexander Psiuk";
      $friends["martin"] = "Martin Jergler";
      $friends["fana"] = "Christoph Grill";
      $friends["doedl"] = "Markus Doering";
      $friends["marco"] = "Marco Polo";
      
      $buffer = "";
      foreach ($friends as $key=>$value)
      {
        $buffer .= "<li id=\"".$key."\">".$value."</li>";        
        next($friends); 
      }

      return $buffer;
    }
//--- 8< snap -----------

}
