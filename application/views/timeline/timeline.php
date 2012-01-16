<script>

$(document).ready(function()
{

});  
  
</script>

<style>

@font-face
{  
  font-family: Segoe;  
  src: url(../../css/segoeui.ttf) format("truetype");  
}  
@font-face
{  
  font-family: SegoeLight;  
  src: url(../../css/segoeuil.ttf) format("truetype");  
}  

h1
{
  width:40%;
  padding:10px;
  font-family: SegoeLight, verdana, helvetica, sans-serif;
  color:#666;
  font-size:40px;
}

div
{
  font-family:Segoe UI;
}

hr.todayruler
{
  position:relative;
  width:200px;
  margin:0px auto;
  border-top:1px solid #fff;
  z-index:999;
}

.day
{
  box-shadow:inset 2px 0px 8px #ccc;
  position:relative;
  left:45%;
  color:#999;
  width:25px;
  height:48px;
}

a
{
  text-decoration:none;
  color:#999;
}

.day span.date
{
  position:relative;
  top:0px;
  left:0px;
  border-top:1px solid #ccc;
  padding-left:50px;
  color:#ccc;
  height:40px;
  width:100px;
  display:block;
}

.day:nth-child(even)
{
  background-color:#e6e6e6;
}

.day:nth-child(odd)
{
  background-color:#e0e0e0;
}

.event
{
  box-shadow:inset 2px 0px 8px #999;
  position:absolute;
  background-color:#2bc0e8;
  color:#fff;
  width:25px;
  display:block;
}

.eventlabel
{
  position:absolute;
  width:200px;
  left:-200px;
  display:block;
  border-left:1px dotted #ccc;
  padding-left:10px;
  color:#999;
}

.owneventlabel
{
  position:absolute;
  width:200px;
  left:-200px;
  display:block;
  border-left:3px dotted #666;
  padding-left:10px;
  color:#999;
}

.eventmembers
{
  position:absolute;
  width:300px;
  left:150px;
  display:block;
  padding-right:10px;
  color:#999;
}

.eventmembers img
{
  width:48px;
  height:48px;
  margin:5px;
  border-radius:5px;
  vertical-align:middle;
}

</style>

<div id="window">
  <ul id="pages">
    <li>
      <div id="timeline">        
        <h1>Timeline</h1>
      <?php
      echo anchor("event","<button>zu den Events</button>");
      echo anchor("event/new","<button>Neues Event</button>");
      
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
            echo "<hr class='todayruler' style='top:".$hourOffset."px;'/>";
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
