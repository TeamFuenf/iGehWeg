<?php

class Timeline_forms extends CI_Model
{
    private $hours = array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23");
    private $minutes = array("00","05","10","15","20","25","30","35","40","45","50","55");
    
    function __construct()
    {
        parent::__construct();
        $this->load->helper("form");
        $this->load->helper("html");
        $this->load->helper("url");
    }
    
    function location()
    {
      //TODO endzeit muss später sein
      //TODO Tag wählen
     
      $from_hour = date("G");
      $from_minute = round(date("i")/5);
      $to_hour = (date("G") + 1);
      $to_minute = round(date("i")/5);
      
      $buffer = "";
      $buffer .= form_label("Was?", "title");
      $buffer .= form_input("title").br();

      $buffer .= form_label("Wo?", "location");
      $buffer .= form_input("location").br();

      $buffer .= form_label("Von?", "from_hour");
      $buffer .= form_dropdown("from_hour", $this->hours, $from_hour);
      $buffer .= form_dropdown("from_minutes", $this->minutes, $from_minute);
      $buffer .= br();
      
      $buffer .= form_label("Bis?", "to_hour");
      $buffer .= form_dropdown("to_hour", $this->hours, $to_hour);
      $buffer .= form_dropdown("to_minutes", $this->minutes, $to_minute);
      $buffer .= br();

      return $buffer;
    }

    function friends()
    {
      $buffer  = "<ul>";
      // TODO von Fausi
      $buffer .= $this->getFriends();
      $buffer .= "</ul>";
      return $buffer;
    }
    
    function comment()
    {
      
      $buffer = "";     
      $buffer .= form_textarea("comment").br();

      $submitbutton["name"] = "submit";
      $submitbutton["content"] = "fertig";
      $submitbutton["type"] = "submit";
      return $buffer;
    }
    
    public function backlink()
    {
      $buffer = anchor("timeline", "fertigstellen", "class=\"button\"");
      return $buffer;
    }
    
// --------------------------------------------------------------------------------------------------------------------

    function getFriends()
    {
      $friends["hannes"] = "Hannes Koeppel";
      $friends["philipp"] = "Philipp Fauser";
      $friends["alex"] = "Alexander Psiuk";
      $friends["martin"] = "Martin Jergler";
      $friends["fana"] = "Christoph Grill";
      $friends["doedl"] = "Markus Doering";
      $friends["marco"] = "Marco Polo";
      
      $buffer = "<ul class=\"friends\">";
      foreach ($friends as $friend)
      {
        $buffer .= "<li id=\"".key($friends)."\">".$friend."</li>";        
        next($friends); 
      }
      $buffer .= "</ul>";

      return $buffer;
    }

}
