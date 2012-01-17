<script>

$(document).ready(function()
{

});  
  
</script>

<div id="window">
  <ul id="pages">
    <li>
      <div id="timeline">        
        <h1>Timeline:</h1>
      <?php
      echo anchor("event/new","neues Event", "class='button_normal new_event_button'");
      echo anchor("event","Events", "class='button_normal'");
      
      $showDaysInAdvance = 14;
      for ($i=0; $i <= $showDaysInAdvance; $i++)
      {
        $date = strtotime("+".$i." day");
        $todaysEvents = array();
        foreach($events as $event)
        {
          if ($event->day == date("j", $date) && $event->month == date("n", $date))
          {
            $todaysEvents[] = $event;            
          }
        }

        if (count($todaysEvents) > 0)
        {
          if ($i == 0)
          {
            $hourOffset = date("G") * 20;
            // echo "<hr class='todayruler' style='top:".$hourOffset."px;'/>";
			echo "<div class='todayruler' style='top:".$hourOffset."px;'>now</div>";
            echo "<div class='day today' style='height:480px'>";            
          }
          else
          {
            echo "<div class='day' style='height:480px'>";           
          }
        }
        else
        {
          if ($i == 0)
          {
            $hourOffset = date("G") * 2;
            echo "<hr class='todayruler' style='top:".$hourOffset."px;'/>";
            echo "<div class='day today'>";          
          }
          else
          {
            echo "<div class='day'>";                      
          }
        }
        
        $datelabel = "<span class='date'>".date("d.m.Y", $date)."</span>";
        echo anchor("event/new/".$date , $datelabel);

        foreach ($todaysEvents as $event)
        {
          $top = $event->offset1+20;
          $height = $event->offset2 - $event->offset1;
          
          $begin = date("H:i", $event->begintime);
          $end = date("H:i", $event->endtime);
          echo "<div class='event' style='top:".$top."px; height:".$height."px'>";
          echo "</div>";          

          if ($event->creator == $userid)
          {
            echo "<div class='owneventlabel' style='top:".$top."px; height:".$height."px'>";            
          }
          else
          {
            echo "<div class='eventlabel' style='top:".$top."px; height:".$height."px'>";            
          }
          
          echo anchor("event/".$event->id, "<b>".$begin."-".$end."</b><br/>".$event->title);            
          echo "</div>";          

          echo "<div class='eventmembers' style='top:".$top."px; height:".$height."px'>";
          echo img($eventcreators[$event->id]->picture)." + ";
          // Alternativ:
          //echo "Veranstalter: ".img($eventcreators[$event->id]->picture)."<br/>";
          //echo count($eventmembers). " Teilnehmer:";
          
          if (count($eventmembers[$event->id]) < 4)
          {              
            foreach($eventmembers[$event->id] as $member)
            {
              $style = ($member->status == "invited") ? "style='opacity:0.4;'" : "";
              
              if ($member->id == $userid)              
              {
                echo "<img ".$style." src='".$member->picture."'>";                            
              }
              else
              {
                echo anchor("mail/".$member->id,"<img ".$style." src='".$member->picture."'>");                                
              }
            }
          
          }
          else
          {
            echo anchor("event/".$event->id, (count($eventmembers)-1). " Teilnehmer");
          }
          
          echo "</div>";          
        }
        
        echo "</div>";        
      }
      
      ?>
      </div>
    </li>
  </ul>
</div>
